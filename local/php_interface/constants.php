<?php


/* Кол-во выводимых элементов на странице услуги (ajax) */
const BUY_SHOWBY = 2;

//const SITE_URL = 'http://export60.ru/';
//const SITE_URL_CLEAN = 'http://export60.ru';
//// Email
//const LOGO = '/local/templates/export60/assets/images/header/logo.png';
//


// Кеш
const NX_CACHE_CODE =  'nx_';
const NX_CACHE_ENABLED = true;
const CACHE_TTL_S = 36;
const CACHE_TTL_M = 72;
const CACHE_TTL_L = 128;



try {
    if (\Bitrix\Main\Loader::includeModule('iblock')) {
        /**
         * Генерация констант для подключаемых компонентов
         *
         * ID инфоблока ТИПИНФОБЛОКА_КОДИНФОБЛОКА_IBLOCK_ID
         * ID элемента для одноэлементных ТИПИНФОБЛОКА_КОДИНФОБЛОКА_ELEMENT_CODE
         *
         * Соответственно, для элемента должен быть задан символьный код, совпадающий
         * с кодом его родительского инфоблока
         */
        $iblockList = \Bitrix\Iblock\IblockTable::query()
            ->setSelect(['ID', 'CODE', 'IBLOCK_TYPE_ID'])
            ->setCacheTtl(CACHE_TTL_L)
            ->exec();
        foreach ($iblockList as $iblock) {
            $constant = strtoupper($iblock['IBLOCK_TYPE_ID']) . '_' . strtoupper($iblock['CODE']) . '_IBLOCK_ID';
            define($constant, $iblock['ID']);

            $constant = strtoupper($iblock['IBLOCK_TYPE_ID']) . '_' . strtoupper($iblock['CODE']) . '_IBLOCK_TYPE_ID';
            define($constant, $iblock['IBLOCK_TYPE_ID']);

            $constant = strtoupper($iblock['IBLOCK_TYPE_ID']) . '_' . strtoupper($iblock['CODE']) . '_ELEMENT_CODE';
            define($constant, $iblock['CODE']);
        }
        unset($iblockList);

        /** Загрузка глобальных настроек в константы */
//        if (defined('CONTACTS_CONTACTS_IBLOCK_ID')
//            && !empty(constant('CONTACTS_CONTACTS_IBLOCK_ID'))
//            && class_exists('\dnext\Models\Contacts\Contacts')) {
//            try {
//
//                $contacts = \dnext\Models\Contacts\Contacts::instance()->getConstants();
//
//                foreach ($contacts as $code => $value) {
//                    if (!empty($value)) {
//
//                        define('CONTACT_' . $code, $value);
//                    }
//                }
//
//                define('YANDEX_API_KEY', \dnext\Helpers\UrlHelper::getYandexAPIKey());
//            } catch (\Exception $e) {
//                CEventLog::Log(CEventLog::SEVERITY_ERROR, 'CONSTANTS_INIT', 'main', '', $e->getMessage());
//            }
//        }
    }
} catch (\Exception $e) {
    die($e->getMessage());
    CEventLog::Log('ERROR', 'CONSTANTS_INIT', 'main', '', $e->getMessage());
}




