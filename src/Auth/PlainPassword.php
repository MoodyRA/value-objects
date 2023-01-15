<?php

namespace Moody\ValueObject\Auth;

use Moody\ValueObject\BasicString;
use Moody\ValueObject\ValueObjectIncorrectValueException;
use RuntimeException;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException;

/** @phpstan-consistent-constructor */
class PlainPassword extends BasicString
{
    /**
     * @param string $value
     * @throws ValueObjectIncorrectValueException
     */
    public function __construct(string $value)
    {
        try {
            Assert::minLength($value, 8);
        } catch (InvalidArgumentException $e) {
            throw new ValueObjectIncorrectValueException('Password must be at least 8 characters long');
        }

        if (!preg_match('/[A-Z]/', $value)) {
            throw new ValueObjectIncorrectValueException('Password must contain at least one uppercase letter');
        }
        if (!preg_match('/[a-z]/', $value)) {
            throw new ValueObjectIncorrectValueException('Password must contain at least one lowercase letter');
        }
        if (!preg_match('/[0-9]/', $value)) {
            throw new ValueObjectIncorrectValueException('Password must contain at least one number');
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