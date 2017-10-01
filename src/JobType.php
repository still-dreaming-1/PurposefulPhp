<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class JobType
{
    /** @var string */
    private $name;
    /** @var Condition[] */
    private $postconditionGroup;
    /** @var CustomerCalledWithCondition[] */
    private $preconditionGroup;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->postconditionGroup = [];
    }

    public function addPostcondition(Condition $condition): void
    {
        $this->postconditionGroup[] = $condition;
    }

    public function hasPostconditions(): bool
    {
        return !empty($this->postconditionGroup);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addPrecondition(CustomerCalledWithCondition $precondition): void
    {
        $this->preconditionGroup[] = $precondition;
    }
}
