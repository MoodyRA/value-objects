<?php

declare(strict_types=1);

namespace Moody\ValueObject\Tests\Identity;

use Moody\ValueObject\Identity\Uuid;
use Moody\ValueObject\ValueObjectIncorrectValueException;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    public function testUuidGenerationFromConstruct(): void
    {
        $uuid = new Uuid();
        $this->assertNotEmpty($uuid->getValue());
    }

    public function testUuidGenerationFromStaticMethod(): void
    {
        $uuid = Uuid::generate();
        $this->assertNotEmpty($uuid->getValue());
    }

    public function testUuidIsCorrect(): void
    {
        $uuid = new Uuid('c9da6c7a-5b3a-4f3a-8c1a-6c9c4d9c5d6e');
        $this->assertEquals('c9da6c7a-5b3a-4f3a-8c1a-6c9c4d9c5d6e', $uuid->getValue());
    }

    public function testUuidIsIncorrect(): void
    {
        $this->expectException(ValueObjectIncorrectValueException::class);
        new Uuid('c9da6c7a-5b3a-4f3a-8c1a-6c9c4d9c5d6');
    }
}