<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class Job
{
    /**
     * @var array
     */
    public $args;
    /**
     * @var JobType
     */
    public $jobType;

    public function __construct()
    {
        $this->args = [];
    }
}
