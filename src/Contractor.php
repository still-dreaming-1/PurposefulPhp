<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class Contractor
{
    private $customer;
    private $jobTypeGroup;
    private $currentJob;
    private $properties;

    public function __construct()
    {
        $this->jobTypeGroup = [];
        $this->properties = [];
        $this->properties['injectedMethodGroup'] = [];
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
        $relationshipGroup = $job->jobType->getRelationships();
        foreach ($relationshipGroup as $relationship) {
            if ($relationship->getPerformedBefore() !== null) {
                $this->performInjection();
                return;
            }
        }
        foreach ($relationshipGroup as $relationship) {
            if ($relationship->getPerformedAfter() !== null) {
                $callResult = $this->tryPerformCallInjected();
                if ($callResult->wasSuccessful) {
                    return $callResult->value;
                }
                $this->throwMissingMethodException($job->arguments[0]);
            }
        }
    }

    private function performInjection(): void
    {
        $this->properties['injectedMethodGroup'][] = array($this->currentJob->arguments[0], $this->currentJob->arguments[1]);
    }

    private function tryPerformCallInjected(): Result
    {
        $result = new Result();
        foreach ($this->properties['injectedMethodGroup'] as $injectedMethod) {
            if ($injectedMethod[0] === $this->currentJob->arguments[0]) {
                $result->wasSuccessful = true;
                $result->value = \call_user_func_array($injectedMethod[1], $this->currentJob->arguments[1]);
                break;
            }
        }
        return $result;
    }

    private function throwMissingMethodException(string $methodName): void
    {
        throw new \StillDreamingOne\PurposefulPhp\Examples\Dci\DciException("Missing method ".$methodName);
    }
}
