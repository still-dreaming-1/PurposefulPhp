<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class Contractor
{
    private $arguments;
    private $customer;
    private $postcondition;

    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    public function addPostcondition(Condition $condition)
    {
        $this->postcondition = $condition;
    }

    public function fulfill()
    {
        if ($this->postcondition !== null) {
            $this->customer->{$this->arguments[0]} = $this->arguments[1];
            return;
        }
        if (!\property_exists($this->customer, $this->arguments[0])) {
            $this->throwMissingMethodException($this->arguments[0]);
        }
        $possibleClosure = $this->customer->{$this->arguments[0]};
        if ($possibleClosure instanceof \Closure) {
            return \call_user_func_array($possibleClosure, $this->arguments[1]);
        }
        $this->throwMissingMethodException($this->arguments[0]);
    }

    private function throwMissingMethodException(string $methodName)
    {
        throw new \StillDreamingOne\PurposefulPhp\Examples\Dci\DciException("Missing method ".$methodName);
    }
}
