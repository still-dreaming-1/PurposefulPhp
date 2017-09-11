<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class Job
{
    public $name;
    public $arguments;
    public $postcondition;

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    public function addPostcondition(Condition $condition)
    {
        $this->postcondition = $condition;
    }
}
