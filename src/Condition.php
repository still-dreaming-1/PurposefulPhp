<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class Condition
{
    /**
     * @var When
     */
    private $when;
    /**
     * @var When
     */
    private $andThen;
    /**
     * @var Then
     */
    private $then;

    public function when(): When
    {
        $this->when = new When($this);
        return $this->when;
    }

    public function andThen(): When
    {
        $this->andThen = new When($this);
        return $this->andThen;
    }

    public function then(): Then
    {
        $this->then = new Then();
        return $this->then;
    }

    public function customerCalledWith(string $methodName, $nameArg, $preconditionAnyClosure): void
    {
    }
}
