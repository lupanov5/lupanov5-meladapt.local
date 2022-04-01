<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * @var $arResult
 * @var $arParams
 * @global CMain $APPLICATION
 */
?>
<?php
foreach ($arResult as $key => $item) {
    if ($item['LINK'] === '/#buy' && !$arParams['CHECKBOX']) {
        unset($arResult[$key]);
    }
}

