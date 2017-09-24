<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class When
{
    /**
     * After $methodName, pass the parameters it is called with
     */
    public function customerCallsWith(string $methodName): void
    {
        $arguments = \func_get_args();
    }
}
