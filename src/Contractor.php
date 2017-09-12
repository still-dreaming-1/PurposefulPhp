<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class Contractor
{
    private $customer;
    private $jobTypeGroup;

    public function __construct()
    {
        $this->jobTypeGroup = [];
    }

    public function setCustomer($customer): void
    {
        $this->customer = $customer;
    }

    public function addJobType(JobType $jobType): void
    {
        $this->jobTypeGroup[$jobType->getName()] = $jobType;
    }

    public function perform(Job $job)
    {
        if ($job->jobType->hasPostconditions()) {
            $this->customer->{$job->arguments[0]} = $job->arguments[1];
            return;
        }
        if (!\property_exists($this->customer, $job->arguments[0])) {
            $this->throwMissingMethodException($job->arguments[0]);
        }
        $possibleClosure = $this->customer->{$job->arguments[0]};
        if ($possibleClosure instanceof \Closure) {
            return \call_user_func_array($possibleClosure, $job->arguments[1]);
        }
        $this->throwMissingMethodException($job->arguments[0]);
    }

    private function throwMissingMethodException(string $methodName): void
    {
        throw new \StillDreamingOne\PurposefulPhp\Examples\Dci\DciException("Missing method ".$methodName);
    }
}
