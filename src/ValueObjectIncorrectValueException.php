<?php

declare(strict_types=1);

namespace Moody\ValueObject;

class ValueObjectIncorrectValueException extends \UnexpectedValueException
{
    public function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}