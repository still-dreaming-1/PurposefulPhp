<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

use StillDreamingOne\PurposefulPhp\ArgTrap;

final class ArgFilter
{
    /** @var ArgTrap */
    private $argTrap;

    public function __construct(ArgTrap $argTrap)
    {
        $this->argTrap = $argTrap;
    }
}
