<?php

declare(strict_types=1);

namespace Moody\ValueObject\Tests\Auth;

use Moody\ValueObject\Auth\HashedPassword;
use Moody\ValueObject\Auth\PlainPassword;
use Moody\ValueObject\ValueObjectIncorrectValueException;
use PHPUnit\Framework\TestCase;

class PlainPasswordTest extends TestCase
{
    public function testPasswordIsCorrect(): void
    {
        $password = new PlainPassword('correct_- *Password8');
        $this->assertEquals('correct_- *Password8', $password->getValue());
    }

    public function testPasswordNotContains8Characters(): void
    {
        $this->expectException(ValueObjectIncorrectValueException::class);
        new PlainPassword('Short5');
    }

    public function testPasswordNotContains1UppercaseLetter(): void
    {
        $this->expectException(ValueObjectIncorrectValueException::class);
        new PlainPassword('lowercase8');
    }

    public function testPasswordNotContains1LowercaseLetter(): void
    {
        $this->expectException(ValueObjectIncorrectValueException::class);
        new PlainPassword('UPPERCASE8');
    }

    public function testPasswordNotContains1Number(): void
    {
        $this->expectException(ValueObjectIncorrectValueException::class);
        new PlainPassword('NoNumber');
    }

    public function testHashPassword(): void
    {
        $password = new PlainPassword('correct_Password8');
        $this->assertInstanceOf(HashedPassword::class, $password->hash());
    }
}