<?php

namespace Moody\ValueObject\Auth;

use Moody\ValueObject\BasicString;
use Moody\ValueObject\ValueObjectIncorrectValueException;
use RuntimeException;

/** @phpstan-consistent-constructor */
class PlainPassword extends BasicString
{
    /**
     * @param string $value
     * @throws ValueObjectIncorrectValueException
     */
    public function __construct(string $value)
    {
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/';
        if (!\preg_match($pattern, $value)) {
            throw new ValueObjectIncorrectValueException(
                "The password must contains 8 characters minimun with at least one uppercase letter, one lowercase letter and one number"
            );
        }
        parent::__construct($value);
    }

    /**
     * @throws ValueObjectIncorrectValueException
     */
    public static function fromString(string $value): self
    {
        return new self($value);
    }

    /**
     * @throws RuntimeException
     */
    public function hash(): HashedPassword
    {
        return HashedPassword::fromPlain($this);
    }
}