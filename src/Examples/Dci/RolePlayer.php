<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp\Examples\Dci;

use StillDreamingOne\PurposefulPhp\{
    Contractor,
    JobType,
    Job,
    Condition,
    Any,
    Arg,
    ArgTrap,
    ArgFilter
};

// helps with the DCI style of OO in php
final class RolePlayer
{
    /** @var Contractor */
    private $contractor;

    public function __construct()
    {
        $this->contractor = new Contractor();
        $this->contractor->setCustomer($this);
        $this->contractor->addRelationship($this->getInjectMethodAndCallRelationship());
    }

    /**
     * when {
     *     $this->injectMethod($name, $method)
     * } and then {
     *     $this->_call($name, $args)
     * } then {
     *     called closure {
     *       $method($args);
     *     }
     * }
     */
    private function getInjectMethodAndCallRelationship(): Condition
    {
        $relationship = new Condition();
        $nameTrap = new ArgTrap();
        $methodTrap = new ArgTrap();
        $argsTrap = new ArgTrap();
        $relationship
            ->when()
                ->methodCallsWith('injectMethod', $nameTrap, $methodTrap)
            ->andThen()
                ->methodCallsWith('__call', new ArgFilter($nameTrap), $argsTrap)
            ->then()
                ->closureIsCalledWithParam($methodTrap, $argsTrap);
        return $relationship;
    }

    public function injectMethod(string $name, \Closure $method): void
    {
        $jobType = $this->addInjectMethodJobType(__FUNCTION__, $name, $method);
        $job = new Job();
        $job->jobType = $jobType;
        $job->args = \func_get_args();
        $this->contractor->perform($job);
    }

    private function addInjectMethodJobType(string $jobName, string $methodName, \Closure $method): JobType
    {
        $jobType = new JobType($jobName);
        $this->contractor->addJobType($jobType);
        return $jobType;
    }

    public function __call(string $name, array $args)
    {
        $jobType = $this->addCallJobType(__FUNCTION__, $name);
        $job = new Job();
        $job->jobType = $jobType;
        $job->args = \func_get_args();
        return $this->contractor->perform($job);
    }

    private function addCallJobType(string $jobName, string $nameArg): JobType
    {
        $jobType = new JobType($jobName);
        $precondition = new Condition();
        $anyClosure = new Any(\Closure::class);
        // required arguments left off can be anything
        $precondition->customerCalledWith('injectMethod', $nameArg, $anyClosure);
        $jobType->addPrecondition($precondition);

        $this->contractor->addJobType($jobType);
        return $jobType;
    }
}
