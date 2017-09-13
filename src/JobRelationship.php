<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class JobRelationship
{
    private $performedAfter; // should be a precondition when calling an injected
    private $performedBefore; // should be a postcondition when injecting

    public function setPerformedAfter(string $jobName): void
    {
        $this->performedAfter = $jobName;
        $this->ensureOnlyPerformedAfterRelationshipDefined();
    }

    private function ensureOnlyPerformedAfterRelationshipDefined(): void
    {
        $this->performedBefore = null;
    }

    public function getPerformedBefore(): ?string
    {
        return $this->performedBefore;
    }

    public function setPerformedBefore(string $jobName): void
    {
        $this->performedBefore = $jobName;
        $this->ensureOnlyPerformedBeforeRelationshipDefined();
    }

    private function ensureOnlyPerformedBeforeRelationshipDefined(): void
    {
        $this->performedAfter = null;
    }

    public function getPerformedAfter(): string
    {
        return $this->performedAfter;
    }
}
