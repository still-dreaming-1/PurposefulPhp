<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class Contractor
{
    private $customer;
    private $jobTypeGroup;
    private $currentJob;

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
        $this->currentJob = $job;
        if ($job->jobType->hasPostconditions()) {
            $this->performInjection();
            return;
        }
        if (!\property_exists($this->customer, $job->arguments[0])) {
            $this->throwMissingMethodException($job->arguments[0]);
        }
        $callResult = $this->tryPerformCallInjected();
        if ($callResult->wasSuccessful) {
            return $callResult->value;
        }
        $this->throwMissingMethodException($job->arguments[0]);
    }

    private function performInjection(): void
    {
        $this->customer->{$this->currentJob->arguments[0]} = $this->currentJob->arguments[1];
    }

    private function tryPerformCallInjected(): Result
    {
        $possibleClosure = $this->customer->{$this->currentJob->arguments[0]};
        $result = new Result();
        if ($possibleClosure instanceof \Closure) {
            $result->wasSuccessful = true;
            $result->value = \call_user_func_array($possibleClosure, $this->currentJob->arguments[1]);
        }
        return $result;
    }

    private function throwMissingMethodException(string $methodName): void
    {
        throw new \StillDreamingOne\PurposefulPhp\Examples\Dci\DciException("Missing method ".$methodName);
    }
}
