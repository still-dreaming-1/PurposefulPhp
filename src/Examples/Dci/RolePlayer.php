<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp\Examples\Dci;

use StillDreamingOne\PurposefulPhp\{
    Contractor,
    Condition
};

// helps with the DCI style of OO in php
final class RolePlayer
{
    public function injectMethod(string $name, \Closure $method)
    {
        $contractor = new Contractor();
        $contractor->setCustomer($this);
        $contractor->setArguments(\func_get_args());
        $condition = new Condition();
        $contractor->addPostcondition($condition);
        $contractor->fulfill();
    }

    public function __call(string $name, $arguments)
    {
        $contractor = new Contractor();
        $contractor->setCustomer($this);
        $contractor->setArguments(\func_get_args());
        return $contractor->fulfill();
    }
}
