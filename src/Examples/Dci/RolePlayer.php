<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp\Examples\Dci;

use StillDreamingOne\PurposefulPhp\{
    Contractor,
    Job,
    Condition
};

// helps with the DCI style of OO in php
final class RolePlayer
{
    private $contractor;

    public function __construct()
    {
        $this->contractor = new Contractor();
        $this->contractor->setCustomer($this);
    }

    public function injectMethod(string $name, \Closure $method)
    {
        $job = new Job();
        $job->setName(__FUNCTION__);
        $job->setArguments(\func_get_args());
        $condition = new Condition();
        $job->addPostcondition($condition);
        $this->contractor->perform($job);
    }

    public function __call(string $name, $arguments)
    {
        $job = new Job();
        $job->setName(__FUNCTION__);
        $job->setArguments(\func_get_args());
        return $this->contractor->perform($job);
    }
}
