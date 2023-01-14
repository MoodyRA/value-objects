<?php

declare(strict_types=1);

namespace Moody\ValueObject\Tests;

use Moody\ValueObject\BasicString;
use PHPUnit\Framework\TestCase;

class BasicStringTest extends TestCase
{
    /**
     * @return void
     */
    public function testString(): void
    {
        $string = new BasicString('test');
        $this->assertEquals('test', $string->getValue());
    }

    /**
     * @return void
     */
    public function testEmptyString(): void
    {
        $string = new BasicString('');
        $this->assertTrue($string->isEmpty());
    }

    /**
     * @return void
     */
    public function testToString(): void
    {
        $string = new BasicString('test');
        $this->assertEquals('test', $string);
    }
}