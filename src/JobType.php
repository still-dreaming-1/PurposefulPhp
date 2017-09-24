<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class JobType
{
    private $name;
    /**
     * @var array
     */
    private $postconditionGroup;
    /**
     * @var array
     */
    private $relationshipGroup;
    /**
     * @var
     */
    private $preconditionGroup;

    public function __construct()
    {
        $this->postconditionGroup = [];
        $this->relationshipGroup = [];
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

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function addRelationship(Condition $relationship): void
    {
        $this->relationshipGroup[] = $relationship;
    }

    public function addPrecondition(Condition $precondition): void
    {
        $this->preconditionGroup[] = $precondition;
    }

    public function getRelationships(): array
    {
        return $this->relationshipGroup;
    }
}
