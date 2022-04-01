<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * @var $arResult
 * @global CMain $APPLICATION
 */
?>
<?php

/* GET SETTINGS PAGE */

$arResult['SETTINGS_PAGE'] = \dnext\Models\Question\Settings::instance()->getFirstElement();

$APPLICATION->SetPageProperty('title', $arResult['SETTINGS_PAGE']['ELEMENT_META_TITLE']);
$APPLICATION->SetPageProperty('keywords', $arResult['SETTINGS_PAGE']['ELEMENT_META_KEYWORDS']);
$APPLICATION->SetPageProperty('description', $arResult['SETTINGS_PAGE']['ELEMENT_META_DESCRIPTION']);