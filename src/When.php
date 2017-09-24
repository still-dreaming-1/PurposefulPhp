<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class When
{
    /**
     * @var Condition
     */
    private $relationship;

    public function __construct(Condition $relationship)
    {
        $this->relationship = $relationship;
    }
    /**
     * After $methodName, pass the parameters it is called with
     */
    public function customerCallsWith(string $methodName): Condition
    {
        $arguments = \func_get_args();
        return $this->relationship;
    }
}
