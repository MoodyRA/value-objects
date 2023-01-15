<?php

declare(strict_types=1);

namespace Moody\ValueObject\Tests\Auth;

use Moody\ValueObject\Auth\HashedPassword;
use Moody\ValueObject\Auth\PlainPassword;
use PHPUnit\Framework\TestCase;

class HashedPasswordTest extends TestCase
{
    public function testConstructIsNotCallable(): void
    {
        $this->expectException(\Error::class);
        new HashedPassword('test');
    }

    public function testFromHash(): void
    {
        $password = new PlainPassword('MyCorrect_Password8');
        $hashedPassword = HashedPassword::fromHash($password->hash()->getValue());
        $this->assertInstanceOf(HashedPassword::class, $hashedPassword);
    }

    public function testFromPlain(): void
    {
        $password = new PlainPassword('MyCorrect_Password8');
        $hashedPassword = HashedPassword::fromPlain($password);
        $this->assertInstanceOf(HashedPassword::class, $hashedPassword);
    }

    public function testMatch(): void
    {
        $password = new PlainPassword('MyCorrect_Password8');
        $hashedPassword = HashedPassword::fromPlain($password);
        $this->assertTrue($hashedPassword->match($password));
    }
}