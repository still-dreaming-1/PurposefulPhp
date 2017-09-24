<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class Then
{
    /**
     * @var ArgTrap
     */
    private $methodTrap;
    /**
     * @var ArgTrap
     */
    private $argsTrap;

    public function closureIsCalledWithParam(ArgTrap $methodTrap, ArgTrap $argsTrap): void
    {
        $this->methodTrap = $methodTrap;
        $this->argsTrap = $argsTrap;
    }
}
