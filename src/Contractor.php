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
            throw new \StillDreamingOne\PurposefulPhp\Examples\Dci\DciException("Missing method ".$this->arguments[0]);
        }
        return \call_user_func_array($this->customer->{$this->arguments[0]}, $this->arguments[1]);
    }
}
