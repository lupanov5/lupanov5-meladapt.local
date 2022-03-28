<?php

namespace dnext\Helpers;

/**
 * Class CommonHelper
 * @package dnext\helpers
 */
class CommonHelper
{
    /**
     * Получить телефон без маски
     *
     * @param string $phone
     * @return string
     */
    public static function getPhoneWithoutMask(string $phone): string
    {
        return !empty($phone) ? preg_replace('/[*( +()\-)]/', '', $phone) : "";
    }

    /**
     * Получить массив координат из строки
     *
     * @param string $string
     * @return array|int[]
     */
    public static function getCoordinatesFromString(string $string): array
    {
        $coordinates = explode(',', $string);
        if (count($coordinates) < 2) {
            return [
                'lat' => 0,
                'lng' => 0,
            ];
        }

        return [
            'lat' => $coordinates[0],
            'lng' => $coordinates[1]
        ];
    }

    /**
     * Получить данные о ссылке на ютьюб
     *
     * @param string|null $url
     * @return array|null[]
     */
    public static function getYoutubeData(?string $url)
    {
        $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
        if (preg_match($pattern, $url, $match)) {
            $youtubeId = $match[1];

            return [
                'IMG' => "https://img.youtube.com/vi/" . $youtubeId . "/sddefault.jpg",
                'VIDEO' => $youtubeId,
            ];
        }

        return [
            'IMG' => null,
            'VIDEO' => null,
        ];
    }
}