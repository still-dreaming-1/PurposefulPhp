<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class Contractor
{
    private $arguments;
    private $customer;

    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    public function fulfill()
    {
        return \call_user_func_array($this->customer->{$this->arguments[0]}, $this->arguments[1]);
    }
}
