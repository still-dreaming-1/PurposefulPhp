<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class Any
{
    /** @var string */
    private $class;

    public function __construct(string $class)
    {
        $this->class = $class;
    }
}
