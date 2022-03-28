<?php

namespace dnext\Helpers;


use Bitrix\Main\Context;
use Bitrix\Main\Page\Asset;
use Bitrix\Rest\Marketplace\Url;

class SeoHelper
{
    private static $asset;

    private static $siteUrls = [
        'en' => 'https://notamedia.com',
        'ru' => 'https://integrator.nota.media',
    ];

    private static $siteUrlsTest = [
        'en' => 'http://integrator-en.local',
        'ru' => 'http://integrator.local',
    ];

    private static function setMetaString($string)
    {
        self::$asset = Asset::getInstance();
        self::$asset->addString($string);
    }

    public static function setCanonical()
    {
        $link = self::getCleanUrl();

        if($link) {
            $canonical = sprintf('<link rel="canonical" href="%s">', $link);
            self::setMetaString($canonical);
        }
    }

    /**
     * Устанавалиаем канонические ссылки только для страниц с лишними get параметрами
     * @return false|string
     */
    private static function getCleanUrl()
    {
        /**
         * @var UrlHelper
         */
        $cleanUrl = UrlHelper::getBaseUrl() . UrlHelper::getClearRequestUri();
        $dirtyUrl = UrlHelper::getBaseUrl() . Context::getCurrent()->getRequest()->getRequestUri();

        if($cleanUrl !== $dirtyUrl) {
            return $cleanUrl;
        }

        return false;
    }

    /**
     * Установка языка страницы и ссылки на страницу на другом языке
     */
    public static function setAlternativeUrl()
    {
        if(!self::isExcluded()) {
            $alternateLang = LANGUAGE_ID === 'ru' ? 'en' : 'ru';

            $link = self::getSites()[$alternateLang].UrlHelper::getClearRequestUri();
            $string = sprintf('<link rel="alternate" hreflang="%s" href="%s" />', $alternateLang, $link);
            self::setMetaString($string);

            $link = self::getSites()[LANGUAGE_ID].UrlHelper::getClearRequestUri();
            $string = sprintf('<link rel="alternate" hreflang="%s" href="%s" />', LANGUAGE_ID, $link);
            self::setMetaString($string);
        }
    }

    private static function getSites()
    {
        return self::$siteUrls;
    }

    /**
     * Страницы, которые, скорее всего, не имеют дублей на другом языке мы исключаем
     * @return bool
     */
    private static function isExcluded()
    {
        $current = UrlHelper::getClearRequestUri();
        $patterns = self::getExcludedPatterns();
        foreach ($patterns as $pattern) {
            if(preg_match($pattern, $current)) return true;
        }

        return false;
    }

    /**
     * Паттерны, для которых не устанаваливается ссылка на альтернативный язык
     * @return string[]
     */
    private static function getExcludedPatterns()
    {
        return [
            '/(\/news\/(.))/',
            '/(\/career\/(.))/',
        ];
    }

    /**
     * @param $ogImage
     * @param bool $absoluteUrl
     */
    public static function setOgImage($ogImage = '', $absoluteUrl = false)
    {
        if(!empty($ogImage)) {

            if (!$absoluteUrl) {
                $ogImage = UrlHelper::getBaseUrl() . $ogImage;
            }
            $ogImage = '<meta property="og:image" content="' . $ogImage . '">';
            /**
             * @global $APPLICATION
             */
            global $APPLICATION;
            $APPLICATION->SetPageProperty('og-image', $ogImage);
        }
    }
}
