<?php

declare(strict_types=1);

namespace Moody\ValueObject\Tests\Web;

use Moody\ValueObject\ValueObjectIncorrectValueException;
use Moody\ValueObject\Web\EmailAddress;

class EmailAddressTest extends \PHPUnit\Framework\TestCase
{
    private const VALID_EMAIL_ADDRESS = 'correct_email@mail.fr';
    private const INVALID_EMAIL_ADDRESS = 'incorrect_email@mail';

    public function testEmailAddressIsCorrect(): void
    {
        $emailAddress = new EmailAddress(self::VALID_EMAIL_ADDRESS);
        $this->assertEquals(self::VALID_EMAIL_ADDRESS, $emailAddress->getValue());
    }

    public function testEmailAddressIsIncorrect(): void
    {
        $this->expectException(ValueObjectIncorrectValueException::class);
        new EmailAddress(self::INVALID_EMAIL_ADDRESS);
    }

    public function testGetLocalPart(): void
    {
        $emailAddress = new EmailAddress(self::VALID_EMAIL_ADDRESS);
        $this->assertEquals('correct_email', $emailAddress->getLocalPart());
    }

    public function testGetDomainPart(): void
    {
        $emailAddress = new EmailAddress(self::VALID_EMAIL_ADDRESS);
        $this->assertEquals('mail.fr', $emailAddress->getDomainPart());
    }
}