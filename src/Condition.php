<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp;

final class Condition
{
    /** @var ?When */
    private $when;
    /** @var When */
    private $andThen;
    /** @var ?Then */
    private $then;

    /** @var ?string */
    public function when(): When
    {
        $this->when = new When($this);
        return $this->when;
    }

    public function getWhen(): ?When
    {
        return $this->when;
    }

    public function andThen(): When
    {
        $this->andThen = new When($this);
        return $this->andThen;
    }

    public function getAndThen(): ?When
    {
        return $this->andThen;
    }

    public function then(): Then
    {
        $this->then = new Then();
        return $this->then;
    }

    public function validate(): void
    {
        if (!$this->isValid()) {
            throw new PurposefulException("invalid relationship");
        }
    }

    public function isValid(): bool
    {
        if ($this->when === null)
            return false;
        if (!$this->when->isValid())
            return false;
        if ($this->then === null)
            return false;
        if (!$this->then->isValid())
            return false;
        return true;
    }
}
