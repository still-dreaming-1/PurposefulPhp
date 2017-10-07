<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class Then
{
    /** @var ?ArgTrap */
    private $methodTrap;
    /** @var ?ArgTrap */
    private $argsTrap;

    public function closureIsCalledWithParam(ArgTrap $methodTrap, ArgTrap $argsTrap): void
    {
        $this->methodTrap = $methodTrap;
        $this->argsTrap = $argsTrap;
    }

    public function isValid(): bool
    {
        if ($this->methodTrap === null) {
            return false;
        }
        if ($this->argsTrap === null) {
            return false;
        }
        return true;
    }

    /**
     * Executes this Then. Does not execute the $currentJob, executes this Then. The $currentJob is just the job that is
     * currently being performed by the Contractor
     */
    public function execute(Job $currentJob)
    {
    }
}
