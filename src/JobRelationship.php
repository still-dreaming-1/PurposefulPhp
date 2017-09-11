<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class JobRelationship
{
    private $performedAfter;
    private $performedBefore;

    public function performedAfter(string $jobName)
    {
        $this->performedAfter = $jobName;
    }

    public function performedBefore(string $jobName)
    {
        $this->performedBefore = $jobName;
    }
}
