<?php
/**
 * @var $arResult
 * @global CMain $APPLICATION
 */


/* GET SETTINGS PAGE */

$arResult['SETTINGS_PAGE'] = \dnext\Models\Home\Settings::instance()->getFirstElement();