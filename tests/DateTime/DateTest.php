<?php

namespace Moody\ValueObject\Tests\DateTime;

use Moody\ValueObject\DateTime\Date;
use PHPUnit\Framework\TestCase;

class DateTest extends TestCase
{
    public function testDateIsCorrect(): void
    {
        $date = new Date(2019, 1, 1);
        $this->assertEquals('2019-01-01', $date->toFormat());
    }

    public function testDateIsIncorrectByDay(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        new Date(2019, 1, 32);
    }

    public function testDateIsIncorrectByMonth(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        new Date(2019, 13, 1);
    }

    public function testDateIsIncorrectByYear(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        new Date(-20, 1, 1);
    }

    public function testFrenchToFormat(): void
    {
        $date = new Date(2019, 1, 1);
        $this->assertEquals('01/01/2019', $date->toFormat('d/m/Y'));
    }
}