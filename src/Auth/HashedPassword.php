<?php

namespace Moody\ValueObject\Auth;

use Moody\ValueObject\BasicString;
use RuntimeException;

final class HashedPassword extends BasicString
{
    public const COST = 12;

    /**
     * @param string $hashedPassword
     */
    private function __construct(string $hashedPassword)
    {
        parent::__construct($hashedPassword);
    }

    /**
     * @param PlainPassword $plainPassword
     * @return static
     * @throws RuntimeException
     */
    public static function fromPlain(PlainPassword $plainPassword): self
    {
        $hashedPassword = password_hash($plainPassword->getValue(), PASSWORD_BCRYPT, ['cost' => self::COST]);

        if (!$hashedPassword) {
            throw new RuntimeException('Server error hashing password');
        }
        return new self($hashedPassword);
    }

    /**
     * @param string $hashedPassword
     * @return static
     */
    public static function fromHash(string $hashedPassword): self
    {
        return new self($hashedPassword);
    }

    /**
     * @param PlainPassword $plainPassword
     * @return bool
     */
    public function match(PlainPassword $plainPassword): bool
    {
        return password_verify($plainPassword->getValue(), $this->getValue());
    }
}