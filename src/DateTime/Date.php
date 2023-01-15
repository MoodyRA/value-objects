<?php

namespace Moody\ValueObject\DateTime;

use DateTime;
use Moody\ValueObject\ValueObjectIncorrectValueException;

/** @phpstan-consistent-constructor */
class Date
{
    /**
     * @param int $year
     * @param int $month
     * @param int $day
     * @throws ValueObjectIncorrectValueException
     */
    public function __construct(protected int $year, protected int $month, protected int $day)
    {
        $dateTime = \DateTime::createFromFormat('Y-m-d', "$year-$month-$day");
        $nativeDateErrors = \DateTime::getLastErrors();

        if (
            $nativeDateErrors !== false &&
            ($nativeDateErrors['warning_count'] > 0 || $nativeDateErrors['error_count'] > 0)
        ) {
            throw new ValueObjectIncorrectValueException("Incorrect date");
        }
    }

    /**
     * Returns date as string in format Y-m-d.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toNativeDateTime()->format('Y-m-d');
    }

    /**
     * Returns date as string in format Y-m-d.
     *
     * @param string $format
     * @return string
     */
    public function toFormat(string $format = 'Y-m-d'): string
    {
        return $this->toNativeDateTime()->format($format);
    }

    /**
     * Returns a new Date from a native PHP \DateTime.
     *
     * @param DateTime $date
     * @return Date
     */
    public static function fromNativeDateTime(DateTime $date): Date
    {
        return new static(
            (int)$date->format('Y'),
            (int)$date->format('m'),
            (int)$date->format('d')
        );
    }

    /**
     * Returns current Date.
     *
     * @return Date
     */
    public static function now(): Date
    {
        $dateTimeNow = new DateTime();
        return static::fromNativeDateTime($dateTimeNow);
    }

    /**
     * Tells whether two Date are equal by comparing their values.
     *
     * @param Date $date
     * @return bool
     */
    public function sameValueAs(Date $date): bool
    {
        return $this->getYear() === $date->getYear() &&
            $this->getMonth() === $date->getMonth() &&
            $this->getDay() === $date->getDay();
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @return int
     */
    public function getMonth(): int
    {
        return $this->month;
    }

    /**
     * @return int
     */
    public function getDay(): int
    {
        return $this->day;
    }

    /**
     * Returns a native PHP \DateTime version of the current Date.
     *
     * @return \DateTime
     */
    public function toNativeDateTime(): \DateTime
    {
        $date = new \DateTime();
        $date->setDate($this->year, $this->month, $this->day);
        $date->setTime(0, 0, 0);

        return $date;
    }
}