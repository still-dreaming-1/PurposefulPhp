<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class When
{
    /** @var Condition */
    private $relationship;
    /** @var ?string */
    private $methodName;
    /** @var ?array */
    private $methodArgGroup;

    public function __construct(Condition $relationship)
    {
        $this->relationship = $relationship;
    }

    /**
     * After $methodName, pass the parameters it is called with
     */
    public function methodCallsWith(string $methodName): Condition
    {
        $this->methodName = $methodName;
        $this->methodArgGroup = [];
        $first = true;
        foreach(\func_get_args() as $arg) {
            if ($first) {
                continue;
            }
            $first = false;
            if (!($arg instanceof ArgTrap) && (!($arg instanceof ArgFilter))) {
                throw new PurposefulException("expected argument to be an ArgTrap or ArgFilter");
            }
            $this->methodArgGroup[] = $arg;
        }
        return $this->relationship;
    }

    public function validate(): void
    {
        if (!$this->isValid()) {
            throw new PurposefulException("Invalid when");
        }
    }

    public function isValid(): bool
    {
        return $this->methodName !== null && $this->methodArgGroup !== null;
    }

    /**
     * Updates self given the Job currently being performed. Could affect ->isSatisfied()
     */
    public function update(Job $currentJob)
    {
        if ($this->methodName === $job->jobType->name) {
            foreach($this->methodArgGroup as $arg) {
            }
        }
    }

    public function isSatisfied(): bool
    {
        return false;
    }
}
