<?php

namespace dnext\Helpers;

use IntlDateFormatter;

/**
 * Class DateHelper
 * @package dnext\helpers
 */
class DateHelper
{
    /**
     * Получить строку с датой по формату
     *
     * @param string $date
     * @param string $format
     * @return string
     */
    public static function getDateFromFormat(string $date, string $format): string
    {
        return date_format(date_create($date), $format);
    }

    /**
     * Получить разницу дат в количестве дней
     *
     * @param string $dateEnd
     * @param string $dateStart
     * @return int
     */
    public static function getDaysDiffDate(string $dateEnd, string $dateStart): int
    {
        return (int)date_diff(date_create($dateEnd), date_create($dateStart))->format('%a');
    }


    /**
     * @param string $pattern
     * @return IntlDateFormatter
     */
    private static function getFormatter(string $pattern): IntlDateFormatter
    {
        return IntlDateFormatter::create(
            'ru_RU',
            IntlDateFormatter::FULL,
            IntlDateFormatter::FULL,
            'Europe/Moscow',
            IntlDateFormatter::GREGORIAN,
            $pattern
        );
    }

    private static function getDay($date): string
    {
        return self::getFormatter("dd")->format($date) ?: '';
    }

    private static function getMonth($date): string
    {
        return self::getFormatter("MMMM")->format($date) ?: '';
    }

    private static function getYear($date): string
    {
        return self::getFormatter("Y")->format($date) ?: '';
    }

    /**
     * @param string $date
     * @return string
     */
    public static function getHumanDate(string $date = ''): string
    {
        if(!empty($date))
        $date = date_create($date);
        return self::getDay($date) . ' ' . self::getMonth($date) . ' ' . self::getYear($date);
    }
}