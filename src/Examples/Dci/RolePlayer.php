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
     * Relationship: getInjectMethodAndCallRelationship
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
        $jobType->addRelationship($this->getInjectMethodAndCallRelationship($nameParam, $methodParam));
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
    private function getInjectMethodAndCallRelationship(string $name, \Closure $method): Condition
    {
        $relationship = new Condition();
        $nameTrap = new ArgumentTrap();
        $methodTrap = new ArgumentTrap();
        $argumentsTrap = new ArgumentTrap();
        $relationship
            ->when()
                ->customerCallsWith('injectMethod', $nameTrap, $methodTrap)
            ->andThen()
                ->customerCallsWith('__call', new ArgumentTest($nameTrap), $argumentsTrap);
        $relationship
            ->then()
                ->closureIsCalledWithParam($methodTrap, $argumentsTrap);
        return $relationship;
    }

    /**
     * Relationship: getInjectMethodAndCallRelationship
     */
    public function __call(string $name, array $arguments)
    {
        $jobType = $this->addCallJobType(__FUNCTION__);
        $job = new Job();
        $job->jobType = $jobType;
        $job->arguments = \func_get_args();
        return $this->contractor->perform($job);
    }

    private function addCallJobType(string $jobName, string $nameArg, array $argumentsArg): JobType
    {
        $jobType = new JobType();
        $jobType->setName($jobName);

        $jobType->addRelationship($this->getInjectMethodAndCallRelationship());
        $precondition = new Condition();
        $preconditionAnyClosure = new Any(\Closure::class);
        $precondition->customerCalledWith('injectMethod', $nameArg, $preconditionAnyClosure); // required arguments left off can be anything
        $jobType->addPrecondition($precondition);

        $this->contractor->addJobType($jobType);
        return $jobType;
    }
}
