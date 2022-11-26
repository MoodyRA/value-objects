<?php

namespace Moody\ValueObject\DateTime;

use DateTime;
use UnexpectedValueException;

class Time
{
    /**
     * Returns a new Time objects.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     */
    public function __construct(protected int $hour, protected int $minute, protected int $second)
    {
        $this->verifyHour($hour);
        $this->verifyMinute($minute);
        $this->verifySecond($second);
    }

    /**
     * @param int $hour
     * @return void
     */
    protected function verifyHour(int $hour): void
    {
        $options = [
            'options' => ['min_range' => 0, 'max_range' => 23],
        ];
        if (false === filter_var($hour, FILTER_VALIDATE_INT, $options)) {
            throw new UnexpectedValueException("The hour must be an integer between 0 and 23, $hour given");
        }
    }

    /**
     * @param int $minute
     * @return void
     */
    protected function verifyMinute(int $minute): void
    {
        $options = [
            'options' => ['min_range' => 0, 'max_range' => 59],
        ];
        if (false === filter_var($minute, FILTER_VALIDATE_INT, $options)) {
            throw new UnexpectedValueException("The minute must be an integer between 0 and 59, $minute given");
        }
    }

    /**
     * @param int $second
     * @return void
     */
    protected function verifySecond(int $second): void
    {
        $options = [
            'options' => ['min_range' => 0, 'max_range' => 59],
        ];
        if (false === filter_var($second, FILTER_VALIDATE_INT, $options)) {
            throw new UnexpectedValueException("The second must be an integer between 0 and 59, $minute given");
        }
    }

    /**
     * Returns time as string in format G:i:s.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toNativeDateTime()->format('G:i:s');
    }

    /**
     * Returns time as string in format G:i:s.
     *
     * @param string $format
     * @return string
     */
    public function toFormat(string $format = 'G:i:s'): string
    {
        return $this->toNativeDateTime()->format($format);
    }

    /**
     * Returns a new Time from a native PHP \DateTime.
     *
     * @param DateTime $dateTime
     * @return Time
     */
    public static function fromNativeDateTime(DateTime $dateTime): Time
    {
        return new static(
            (int)$dateTime->format('G'),
            (int)$dateTime->format('i'),
            (int)$dateTime->format('s')
        );
    }

    /**
     * Returns current Time.
     *
     * @return Time
     */
    public static function now(): Time
    {
        $dateTime = new DateTime('now');
        return static::fromNativeDateTime($dateTime);
    }

    /**
     * Return zero time.
     *
     * @return Time
     */
    public static function zero(): Time
    {
        return new static(0, 0, 0);
    }

    /**
     * Tells whether two Time are equal by comparing their values.
     *
     * @param Time $time
     * @return bool
     */
    public function sameValueAs(Time $time): bool
    {
        return $this->getHour() === $time->getHour() &&
            $this->getMinute() === $time->getMinute() &&
            $this->getSecond() === $time->getSecond();
    }

    /**
     * @return int
     */
    public function getHour(): int
    {
        return $this->hour;
    }

    /**
     * @return int
     */
    public function getMinute(): int
    {
        return $this->minute;
    }

    /**
     * @return int
     */
    public function getSecond(): int
    {
        return $this->second;
    }

    /**
     * Returns a native PHP \DateTime version of the current Time.
     * Date is set to current.
     *
     * @return DateTime
     */
    public function toNativeDateTime(): DateTime
    {
        $time = new \DateTime('now');
        $time->setTime($this->getHour(), $this->getMinute(), $this->getSecond());

        return $time;
    }
}