<?php

namespace Moody\ValueObject\Identity;

use UnexpectedValueException;
use Ramsey\Uuid\Uuid as BaseUuid;
use Ramsey\Uuid\Validator\GenericValidator;

class Uuid
{
    /** @var string */
    protected string $value;

    /**
     * UUID constructor.
     *
     * @param string $value
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
        $this->value = (string)$uuid;
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

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}