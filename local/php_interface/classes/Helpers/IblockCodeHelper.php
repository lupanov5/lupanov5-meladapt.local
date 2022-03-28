<?php

namespace dnext\Helpers;
use Bitrix\Main;
use Bitrix\Main\Loader;
use Bitrix\Main\Security;

class IblockCodeHelper
{
    /**
     * Возвращает ID ИБлока по его символьному коду
     * @param null $code
     * @return bool|int
     */
    public static function getIblockIdByCode($code = null)
    {
        $iblocks = false;

        if(!empty(self::getAllIblockCodes()[$code])) {
            $iblocks = (int)self::getAllIblockCodes()[$code];
        }

        return $iblocks;
    }

    /**
     * Возвращает массив код ИБлока => id Иблока
     * @return array
     */
    public static function getAllIblockCodes()
    {
        global $DB;

        $sql = "SELECT ID, CODE FROM `b_iblock`";
        $results = $DB->Query($sql);
        $iblocks = [];
        while ($row = $results->Fetch())
        {
            $iblocks[$row['CODE']] = (int)$row['ID'];//выводим все значения, которые вернул запрос
        }

        return $iblocks;
    }

    public static function getIblockCodeByLanguage($code)
    {
        if(SITE_ID !== 's1') {
            return $code . '_en';
        } else {
            return $code . '_ru';
        }
    }
}