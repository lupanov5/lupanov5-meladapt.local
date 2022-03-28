<?php


namespace dnext\Helpers;

use Bitrix\Main\PhoneNumber\PhoneNumber;
use Bitrix\Main\PhoneNumber\Tools\BoolField;
use CFile;


/**
 * Class Helper
 *
 * @package dnext\Helper
 */
abstract class Generic
{
    public const PLACEHOLDER = '/local/templates/mcis/assets/images/placeholder.png';
    
    /**
     * Сгенерировать UUID
     *
     * @param bool $brackets
     *
     * @return string
     */
    public static function generateUUID(bool $brackets = true): string
    {
        $uuid = '';
        if ($brackets) {
            $uuid .= '{';
        }
        $uuid .= sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            
            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),
            
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,
            
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
            
            // 48 bits for "node"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
        if ($brackets) {
            $uuid .= '}';
        }
        return ($uuid);
    }
    
    /**
     * Получить телефон без маски
     *
     * @param string $phone
     *
     * @return string
     */
    public static function getCleanPhoneNumber(string $phone): string
    {
        $prefix = '';
        if(mb_strpos($phone, '+') === 0) $prefix = '+';

        $result = $phone !== '' ? preg_replace('/\D/', '', $phone) : '';

        return !(empty($result)) ? $prefix . $result : '';
    }
    
    /**
     * Получить изображение по его идентификатору
     *
     * @param int|null $id
     * @param int $width
     * @param int $height
     * @param bool $crop
     * @param bool $changeRatio
     * @param bool $withoutPlaceholder
     *
     * @return mixed
     */
    public static function getImageById(?int $id = 0, int $width = 630, int $height = 450, bool $crop = false, bool $changeRatio = false, bool $withoutPlaceholder = false)
    {
        if (!$withoutPlaceholder && (int)$id <= 0) {
            return self::PLACEHOLDER;
        }
        
        $arImgParams = CFile::_GetImgParams($id);
        $resizeType = BX_RESIZE_IMAGE_PROPORTIONAL_ALT;
        if ($crop) {
            $resizeType = BX_RESIZE_IMAGE_EXACT;
            if ($changeRatio && $width >= $arImgParams['WIDTH'] && $height >= $arImgParams['HEIGHT']) {
                $ratio = $width / $height;
                if ($ratio > 1) {
                    $width = $arImgParams['WIDTH'];
                    $height = $arImgParams['WIDTH'] / $ratio;
                } else {
                    $width = $arImgParams['HEIGHT'] * $ratio;
                    $height = $arImgParams['HEIGHT'];
                }
            }
        }
        
        $arFile = CFile::GetFileArray($id);
        $arrImage = CFile::ResizeImageGet(
            $arFile,
            ['width' => $width, 'height' => $height],
            $resizeType,
            true,
            false,
            false,
            85
        );
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $arrImage['src'])) {
            return $arrImage['src'];
        }
        if (!$withoutPlaceholder) {
            return self::PLACEHOLDER;
        }
        return null;
    }
    
    /**
     * Получить файл по его идентификатору
     *
     * @param ?int $id
     *
     * @return array
     */
    public static function getFilePathById(?int $id = 0): array
    {
        $uploadDir = '/upload/';
        $fileInfo = CFile::GetByID($id)->Fetch() ?: [];
        $path = $uploadDir . $fileInfo['SUBDIR'] . '/' . $fileInfo['FILE_NAME'];
        
        if (!$fileInfo) {
            return [
                'ORIGINAL_NAME' => null,
                'PATH' => null,
            ];
        }
        
        return [
            'ORIGINAL_NAME' => $fileInfo['ORIGINAL_NAME'],
            'PATH' => $path,
        ];
    }
    
    /**
     * @param $haystack
     * @param $needle
     *
     * @return bool
     */
    public static function startsWith($haystack, $needle): bool
    {
        return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
    }
    
    /**
     * @param $haystack
     * @param $needle
     *
     * @return bool
     */
    public static function endsWith($haystack, $needle): bool
    {
        return substr_compare($haystack, $needle, -strlen($needle)) === 0;
    }
    
    /**
     * @param $bytes
     * @param int $decimals
     *
     * @return string
     */
    public static function getFormattedFilesize($bytes, int $decimals = 2): string
    {
        $size = ['б', 'кБ', 'МБ', 'ГБ', 'ТБ', 'PB', 'EB', 'ZB', 'YB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / (1024 ** $factor)) . @$size[$factor];
    }
    
    /**
     * @param $number
     *
     * @return string
     */
    public static function getFormattedPrice($number): string
    {
        return sprintf('%s &#8381;', number_format($number, 0, '', ' '));
    }
    
    /**
     * Склонение для числительных
     *
     * @param $number
     * @param array $expressions
     *
     * @return string
     */
    public static function declension($number, array $expressions): string
    {
        $number = (int)$number;
        $number = (($number < 0) ? $number - $number * 2 : $number) % 100;
        $digit = ($number > 20) ? $number % 10 : $number;
        return trim(
            (($digit == 1) ?
                $expressions[0] :
                (($digit > 4 || $digit < 1) ?
                    $expressions[2] :
                    $expressions[1]))
        );
    }
    
    
    public static function addHighlight(string $highlight, string &$value): void
    {
        $value = preg_replace('/' . $highlight . '/iu', '<span>' . $highlight . '</span>', $value);
    }
}
