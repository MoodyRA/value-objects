<?php

namespace Moody\ValueObject\Identity;

use Moody\ValueObject\BasicString;
use UnexpectedValueException;
use Ramsey\Uuid\Uuid as BaseUuid;
use Ramsey\Uuid\Validator\GenericValidator;

/** @phpstan-consistent-constructor */
class Uuid extends BasicString
{
    /**
     * @param string $value
     * @throws UnexpectedValueException
     */
    public function __construct(string $value = '')
    {
        $uuid = BaseUuid::uuid4();

        if ('' !== $value) {
            $validator = new GenericValidator();
            $pattern = '/' . $validator->getPattern() . '/';

            if (!\preg_match($pattern, $value)) {
                throw new UnexpectedValueException("the passed value doesn't match the pattern");
            }
            $uuid = $value;
        }
        parent::__construct((string)$uuid);
    }

    /**
     * Generate a new UUID string.
     *
     * @return Uuid
     */
    public static function generate(): Uuid
    {
        return new static();
    }
}