<?php

namespace Moody\ValueObject\DateTime;

use DateTime;
use Moody\ValueObject\ValueObjectIncorrectValueException;

/** @phpstan-consistent-constructor */
class Time
{
    /**
     * Returns a new Time objects.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @throws ValueObjectIncorrectValueException
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
     * @throws ValueObjectIncorrectValueException
     */
    protected function verifyHour(int $hour): void
    {
        $options = [
            'options' => ['min_range' => 0, 'max_range' => 23],
        ];
        if (!filter_var($hour, FILTER_VALIDATE_INT, $options)) {
            throw new ValueObjectIncorrectValueException("The hour must be an integer between 0 and 23, $hour given");
        }
    }

    /**
     * @param int $minute
     * @return void
     * @throws ValueObjectIncorrectValueException
     */
    protected function verifyMinute(int $minute): void
    {
        $options = [
            'options' => ['min_range' => 0, 'max_range' => 59],
        ];
        if (!filter_var($minute, FILTER_VALIDATE_INT, $options)) {
            throw new ValueObjectIncorrectValueException(
                "The minute must be an integer between 0 and 59, $minute given"
            );
        }
    }

    /**
     * @param int $second
     * @return void
     * @throws ValueObjectIncorrectValueException
     */
    protected function verifySecond(int $second): void
    {
        $options = [
            'options' => ['min_range' => 0, 'max_range' => 59],
        ];
        if (!filter_var($second, FILTER_VALIDATE_INT, $options)) {
            throw new ValueObjectIncorrectValueException(
                "The second must be an integer between 0 and 59, $second given"
            );
        }
    }

    /**
     * Returns time as string in format H:i:s.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toNativeDateTime()->format('H:i:s');
    }

    /**
     * Returns time as string in format H:i:s.
     *
     * @param string $format
     * @return string
     */
    public function toFormat(string $format = 'H:i:s'): string
    {
        return $this->toNativeDateTime()->format($format);
    }

    /**
     * Returns a new Time from a native PHP \DateTime.
     *
     * @param DateTime $dateTime
     * @return Time
     * @throws ValueObjectIncorrectValueException
     */
    public static function fromNativeDateTime(DateTime $dateTime): Time
    {
        return new static(
            (int)$dateTime->format('H'),
            (int)$dateTime->format('i'),
            (int)$dateTime->format('s')
        );
    }

    /**
     * Returns current Time.
     *
     * @return Time
     * @throws ValueObjectIncorrectValueException
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
     * @throws ValueObjectIncorrectValueException
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