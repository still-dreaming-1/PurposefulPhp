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
        return $this->whenIsValid()
            && $this->andThenIsValid()
            && $this->thenIsValid();
    }

    private function whenIsValid(): bool
    {
        $this->when === null ? is_bool(true) : $this->when->isValid();
        return $this->when === null ? false : $this->when->isValid();
    }

    private function andThenIsValid(): bool
    {
        return $this->andThen === null ? true : $this->andThen->isValid();
    }

    private function thenIsValid(): bool
    {
        return $this->then === null ? false : $this->then->isValid();
    }
}
