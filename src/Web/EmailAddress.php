<?php

declare(strict_types=1);

namespace Moody\ValueObject\Web;

use Moody\ValueObject\BasicString;
use Moody\ValueObject\ValueObjectIncorrectValueException;

class EmailAddress extends BasicString

{
    /**
     * @param string $emailAddress
     * @throws ValueObjectIncorrectValueException
     */
    public function __construct(protected string $emailAddress)
    {
        if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            throw new ValueObjectIncorrectValueException("Invalid email address");
        }
        parent::__construct($emailAddress);
    }

    /**
     * Returns the local part of the email address.
     *
     * @return string
     */
    public function getLocalPart(): string
    {
        $parts = explode('@', $this->getValue());

        return $parts[0];
    }

    /**
     * Returns the domain part of the email address.
     *
     * @return string
     */
    public function getDomainPart(): string
    {
        $parts = \explode('@', $this->getValue());
        return \trim($parts[1], '[]');
    }
}