<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class Condition
{
    public function when(): When
    {
        return new When();
    }

    public function then(): Then
    {
        return new Then();
    }

    public function customerCalledWith(string $methodName, $nameArg, $preconditionAnyClosure): void
    {
    }
}
