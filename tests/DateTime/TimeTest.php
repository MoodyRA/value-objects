<?php

namespace Moody\ValueObject\Tests\DateTime;

use Moody\ValueObject\DateTime\Time;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
    public function testTimeIsCorrect(): void
    {
        $time = new Time(9, 0, 0);
        $this->assertEquals('09:00:00', $time->toFormat());
    }

    public function testTimeIsIncorrectByHour(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        new Time(25, 0, 0);
    }

    public function testTimeIsIncorrectByMinute(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        new Time(0, 60, 0);
    }

    public function testTimeIsIncorrectBySecond(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        new Time(0, 0, 60);
    }

    public function testAnotherFormat(): void
    {
        $time = new Time(9, 0, 0);
        $this->assertEquals('09h00m00s', $time->toFormat('H\hi\ms\s'));
    }
}