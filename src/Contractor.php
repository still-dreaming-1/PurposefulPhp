<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class Contractor
{
    private $customer;

    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    public function perform($job)
    {
        if ($job->postcondition !== null) {
            $this->customer->{$job->arguments[0]} = $job->arguments[1];
            return;
        }
        if (!\property_exists($this->customer, $job->arguments[0])) {
            $this->throwMissingMethodException($job->arguments[0]);
        }
        $possibleClosure = $this->customer->{$job->arguments[0]};
        if ($possibleClosure instanceof \Closure) {
            return \call_user_func_array($possibleClosure, $job->arguments[1]);
        }
        $this->throwMissingMethodException($job->arguments[0]);
    }

    private function throwMissingMethodException(string $methodName)
    {
        throw new \StillDreamingOne\PurposefulPhp\Examples\Dci\DciException("Missing method ".$methodName);
    }
}
