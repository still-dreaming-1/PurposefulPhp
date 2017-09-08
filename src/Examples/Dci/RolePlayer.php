<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp\Examples\Dci;

use StillDreamingOne\PurposefulPhp\Contractor;

// helps with the DCI style of OO in php
final class RolePlayer
{
    public function __call(string $name, $arguments)
    {
        $contractor = new Contractor();
        $contractor->setCustomer($this);
        $contractor->setArguments(\func_get_args());
        return $contractor->fulfill();
    }
}
