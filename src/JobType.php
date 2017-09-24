<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class JobType
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var \StillDreamingOne\PurposefulPhp\Condition[]
     */
    private $postconditionGroup;
    /**
     * @var \StillDreamingOne\PurposefulPhp\Condition[]
     */
    private $relationshipGroup;
    /**
     * @var \StillDreamingOne\PurposefulPhp\Condition[]
     */
    private $preconditionGroup;

    public function __construct(string $name)
    {
        $this->name = $name;
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

    public function addRelationship(Condition $relationship): void
    {
        $this->relationshipGroup[] = $relationship;
    }

    public function addPrecondition(Condition $precondition): void
    {
        $this->preconditionGroup[] = $precondition;
    }

    /**
     * @return Condition[]
     */
    public function getRelationships(): array
    {
        return $this->relationshipGroup;
    }
}
