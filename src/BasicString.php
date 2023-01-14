<?php

declare(strict_types=1);

namespace Moody\ValueObject;

class BasicString
{
    public function __construct(protected string $value)
    {
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getValue();
    }

    /**
     * Tells whether the String is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return 0 === \strlen($this->getValue());
    }
}