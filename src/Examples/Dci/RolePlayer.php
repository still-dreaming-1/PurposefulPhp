<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp\Examples\Dci;

use StillDreamingOne\PurposefulPhp\{
    Contractor,
    JobType,
    Job,
    Condition,
    Argument
};

// helps with the DCI style of OO in php
final class RolePlayer
{
    private $contractor;

    public function __construct()
    {
        $this->contractor = new Contractor();
        $this->contractor->setCustomer($this);
    }

    /**
     * Postcondition:
     * when {
     *    $this->__call($name, $method)
     * } then {
     *    called closure {
     *      $method;
     *    }
     * }
     */
    public function injectMethod(string $name, \Closure $method): void
    {
        $jobType = $this->addInjectMethodJobType(__FUNCTION__, $name, $method);
        $job = new Job();
        $job->jobType = $jobType;
        $job->arguments = \func_get_args();
        $this->contractor->perform($job);
    }

    private function addInjectMethodJobType(string $jobName, string $nameParam, \Closure $methodParam): JobType
    {
        $jobType = new JobType();
        $jobType->setName($jobName);
        $jobType->addRelationship($this->getInjectMethodAndCallRelationship());
        $postcondition = new Condition();
        $postcondition->when()
            ->customerCallsWith('__call', $nameParam, $methodParam);
        $postcondition->then()
            ->closureIsCalledWithParam($methodParam, 'arguments');
        $jobType->addPostcondition($postcondition);
        $this->contractor->addJobType($jobType);
        return $jobType;
    }

    /**
     * when {
     *     $this->injectMethod($name, $method)
     * } and then {
     *     $this->_call($name, $arguments)
     * } then {
     *     called closure {
     *       $method($arguments);
     *     }
     * }
     */
    private function getInjectMethodAndCallRelationship(): Condition
    {
        $condition = new Condition();
        $injectMethodArg = new Argument();
        $injectNameArg = new Argument();
        $injectMethodArg = new Argument();
        $callNameArg = new Argument();
        $callArgumentsArg = new Argument();
        $condition
            ->when()
                ->customerCallsWith('injectMethod', $injectNameArg, $injectMethodArg)
            ->andThen()
                ->customerCallsWith('__call', $callNameArg, $callArgumentsArg);
        $condition
            ->then()
                ->closureIsCalledWithParam($injectMethodArg, $callArgumentsArg);
        return $condition;
    }

    /**
     * Precondition:
     * $this->injectMethod($name, any: \Closure $method)
     *
     * Postcondition:
     * called
     *     closure: $method
     *     with: $arguments
     */
    public function __call(string $name, array $arguments)
    {
        $jobType = $this->addCallJobType(__FUNCTION__);
        $job = new Job();
        $job->jobType = $jobType;
        $job->arguments = \func_get_args();
        $returnValue = $this->contractor->perform($job);
        return $returnValue;
    }

    private function addCallJobType(string $jobName, string $nameArg, array $argumentsArg): JobType
    {
        $jobType = new JobType();
        $jobType->setName($jobName);

        $precondition = new Condition();
        $jobType->addRelationship($this->getInjectMethodAndCallRelationship());
        $jobType->addPrecondition($precondition);
        $preconditionAnyClosure = new Any(\Closure::class);
        $precondition->customerCalledWith('injectMethod', $nameArg, $preconditionAnyClosure); // required arguments left off can be anything

        $postcondition = new Condition();
        $postcondition->closureIsCalledWithParam($preconditionAnyClosure, $argumentsArg);
        $jobType->addPostcondition($postcondition);
        $this->contractor->addJobType($jobType);
        return $jobType;
    }
}
