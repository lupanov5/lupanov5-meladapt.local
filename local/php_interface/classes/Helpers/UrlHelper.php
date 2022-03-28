<?php

namespace dnext\Helpers;

use Bitrix\Main\Context;
use COption;

/**
 * Class UrlHelper - хелпер для работы с урлами
 * @package dnext\helpers
 */
class UrlHelper
{
    // TODO заменить на постоянный
    /**
     * youtube api key
     */
    private const API_KEY ='AIzaSyCEsqnSSGrd67I6HeAlNr8MiBtyEs2OkmM';

    /**
     * Преобразование ссылки
     *
     * @param string $dirtyUrl
     * @return string
     */
    public static function prepareUrl(string $dirtyUrl)
    {
        return preg_replace('/^(https?:)?(\/\/)?(www\.)?/', '', $dirtyUrl);
    }

    /**
     * Преобразование ссылки YouTube
     *
     * @param string $dirtyUrl
     * @return string
     */
    public static function prepareYouTubeUrl(string $dirtyUrl)
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
            $dirtyUrl, $matches);

        return $matches[1];
    }

    /**
     * Получает время видео Youtube по его коду
     *
     * @param $videoId
     * @return string
     * @throws \Exception
     */
    public static function getYouTubeTime($videoId = null)
    {
        //$api_key = 'AIzaSyCEsqnSSGrd67I6HeAlNr8MiBtyEs2OkmM';
        $api_key = self::API_KEY;
        $get_data = file_get_contents('https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails,statistics&id='.$videoId.'&key='.$api_key);
        $get_data = json_decode($get_data, true);
        $resultTime = $get_data['items']['0']['contentDetails']['duration'];

        $resultTime = new \DateInterval($resultTime);
        $totalSeconds = $resultTime->days * 86400 + $resultTime->h * 3600 + $resultTime->i * 60 + $resultTime->s;
        $totalTime = new \DateTime('@'.$totalSeconds);

        $format = 'i:s';
        if($totalSeconds > 86400) {
            $format = 'H:i:s';
        }

        return $totalTime->format($format);
    }

    /**
     * Получение превью видео по id видео с ютюба
     *
     * @param $videoId
     * @return mixed
     */
    public static function getYouTubePreview($videoId = null)
    {
        $data = file_get_contents('https://www.googleapis.com/youtube/v3/videos?key=' . self::API_KEY . '&part=snippet&id=' . $videoId);
        $json = json_decode($data);
        $highImg = $json->items[0]->snippet->thumbnails->high->url;
        $maxImg = $json->items[0]->snippet->thumbnails->maxres->url;

        return !empty($maxImg) ? $maxImg : $highImg;
    }

    /**
     * На входе - youtube url
     * Возворащает массив: url, код видео, время, картинку превью
     *
     * @param $videoUrl
     * @return mixed
     * @throws \Exception
     */
    public static function getYouTubeVideoData($videoUrl = null)
    {
        $result = [];

        if(!empty($videoUrl)) {
            $result['URL'] = $videoUrl;
            $result['ID'] = \dnext\helpers\UrlHelper::prepareYouTubeUrl($videoUrl);
            $result['TIME'] = \dnext\helpers\UrlHelper::getYouTubeTime($result['ID']);
            $result['IMAGE'] = \dnext\helpers\UrlHelper::getYouTubePreview($result['ID']);
        }

        return $result;
    }

    /**
     * Получить из номера телефона только сам номер без других символов
     *
     * @param string $phone
     * @return string
     */
    public static function getClearPhoneNumber(string $phone): string
    {
        return preg_replace('/[  +,()-]/', '', $phone) ?? '';
    }

    /**
     * Получение requestUri без параметров
     *
     * @return string
     */
    public static function getClearRequestUri(): string
    {
        return parse_url(Context::getCurrent()->getRequest()->getRequestUri(), PHP_URL_PATH) ?: '';
    }

    public static function getDevHosts()
    {
        // хак для nginx, который не прокидывает правильно протокол
        return [
            'integrator.local',
            'integrator.dnext.ru',
            'integrator-en.local',
            'integrator-en.dnext.ru',
            'values.integrator-en.local',
            'values.integrator-en.dnext.ru',
        ];
    }

    /**
     * Возвращает, является ли текущий хост - дев хостом
     * @return bool
     */
    public static function devHosts()
    {
        $httpHosts = self::getDevHosts();

        return in_array($_SERVER['HTTP_HOST'], $httpHosts);
    }

    /**
     * Возвращает адрес сайта с используемым протоколом
     * БЕЗ завершающего слеша
     *
     * @return string
     */
    public static function getBaseUrl()
    {
        $request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
        $uri = new \Bitrix\Main\Web\Uri($request->getRequestUri());

        if(self::devHosts()) {
            $baseUrl = $uri->getScheme() . '://' . $_SERVER['HTTP_HOST'];
        } else {
            $baseUrl = 'https://' . $_SERVER['HTTP_HOST'];
        }


        return $baseUrl;
    }

    /**
     * Получение первого сегмента uri без параметров
     *
     * @return string
     */
    public static function getFirstUriPart(): string
    {
        $uriParts = explode('/', static::getClearRequestUri());

        if(!empty($uriParts[1])) return $uriParts[1];

        return '';
    }

    /**
     * Получение первого сегмента uri без параметров
     *
     * @return string
     */
    public static function getSecondUriPart(): string
    {
        //$uriParts = explode('/', static::getClearRequestUri());
        // alternative variant:
        $request = \Bitrix\Main\Context::getCurrent()->getRequest();
        $uriParts = explode('/', $request->getRequestedPageDirectory());

        if(!empty($uriParts[2])) return $uriParts[2];

        return '';
    }

    /**
     * Возвращает ссылку для встраивания видео с ютюба по коду видео
     *
     * @param string $code
     * @return string
     */
    public static function getYouTubeEmbedUrl($code = '')
    {
        return 'https://www.youtube.com/embed/' . $code;
    }

    /**
     * Возвращает ссылку для встраивания видео Youtube
     * по ссылке на видео Youtube
     *
     * @param $url
     * @return string|null
     */
    public static function getYouTubeEmbedUrlByFullUrl($url)
    {
        $code = self::prepareYouTubeUrl($url);
        if(!empty($code)) {
            return self::getYouTubeEmbedUrl($code);
        } else {
            return null;
        }
    }

    /**
     * Получает API ключ Yandex карт из настроек Битрикса (Управление уструктурой)
     * @return false|string|null
     */
    public static function getYandexAPIKey()
    {
        return COption::GetOptionString("fileman", "yandex_map_api_key");
    }
}
