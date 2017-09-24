<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class Contractor
{
    private $customer;
    /**
     * @var Condition[]
     */
    private $relationshipGroup;
    /**
     * @var JobType[]
     */
    private $jobTypeGroup;
    /**
     * @var ?Job
     */
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

    public function addRelationship(Condition $relationship)
    {
        $this->relationshipGroup[] = $relationship;
    }

    public function addJobType(JobType $jobType): void
    {
        $this->jobTypeGroup[$jobType->getName()] = $jobType;
    }

    public function perform(Job $job)
    {
        foreach ($this->relationshipGroup as $relationship) {
            $relationship->validate();
            $when = $relationship->getWhen();
        }
    }

    private function performInjection(): void
    {
        $this->properties['injectedMethodGroup'][] = array($this->currentJob->args[0], $this->currentJob->args[1]);
    }

    private function tryPerformCallInjected(): Result
    {
        $result = new Result();
        foreach ($this->properties['injectedMethodGroup'] as $injectedMethod) {
            if ($injectedMethod[0] === $this->currentJob->args[0]) {
                $result->wasSuccessful = true;
                $result->value = \call_user_func_array($injectedMethod[1], $this->currentJob->args[1]);
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
