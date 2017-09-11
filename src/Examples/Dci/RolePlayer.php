<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp\Examples\Dci;

use StillDreamingOne\PurposefulPhp\{
    Contractor,
    JobType,
    Job,
    JobRelationship,
    Condition
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

    public function injectMethod(string $name, \Closure $method)
    {
        $jobType = $this->addInjectMethodJobType(__FUNCTION__);
        $job = new Job();
        $job->jobType = $jobType;
        $job->arguments = \func_get_args();
        $this->contractor->perform($job);
    }

    private function addInjectMethodJobType($name): JobType
    {
        $jobType = new JobType();
        $jobType->setName($name);
        $relationship = new JobRelationship();
        $relationship->performedBefore('__call');
        $jobType->addRelationship($relationship);
        $condition = new Condition();
        $jobType->addPostcondition($condition);
        $this->contractor->addJobType($jobType);
        return $jobType;
    }

    public function __call(string $name, $arguments)
    {
        $jobType = $this->addCallJobType(__FUNCTION__);
        $job = new Job();
        $job->jobType = $jobType;
        $job->arguments = \func_get_args();
        $returnValue = $this->contractor->perform($job);
        return $returnValue;
    }

    private function addCallJobType($jobName): JobType
    {
        $jobType = new JobType();
        $jobType->setName($jobName);
        $relationship = new JobRelationship();
        $relationship->performedAfter('injectMethod');
        $jobType->addRelationship($relationship);
        /* $condition = new Condition(); */
        /* $jobType->addPostcondition($condition); */
        $this->contractor->addJobType($jobType);
        return $jobType;
    }
}
