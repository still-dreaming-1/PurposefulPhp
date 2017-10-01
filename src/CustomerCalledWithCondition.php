<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class CustomerCalledWithCondition
{
    /** @var ?string */
    private $methodName;
    /** @var array */
    private $methodArgs;

    public function __construct()
    {
        $this->methodArgs = [];
    }

    public function setMethodName(string $name)
    {
        $this->methodName = $name;
    }

    public function setMethodArgs(array $args)
    {
        $this->methodArgs = $args;
    }
}
