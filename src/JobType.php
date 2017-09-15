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

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function addRelationship(Condition $relationship)
    {
        $this->relationshipGroup[] = $relationship;
    }

    public function getRelationships(): array
    {
        return $this->relationshipGroup;
    }
}
