<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class JobType
{
    public $name;
    public $postcondition;
    public $relationship;

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function addPostcondition(Condition $condition)
    {
        $this->postcondition = $condition;
    }

    public function addRelationship(JobRelationship $relationship)
    {
        $this->relationship = $relationship;
    }
}
