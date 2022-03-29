<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Page\Asset;
use Bitrix\Main\Page\AssetLocation;


/**
 * @global CMain $APPLICATION
 * @global CDatabase $DB
 * @global CUser $USER
 */

$asset = Asset::getInstance();

$asset->addString(
    '<link rel="icon" type="image/png" href="' . SITE_TEMPLATE_PATH . '/favicon.png">',
    AssetLocation::BEFORE_CSS
);
$asset->addCss(SITE_TEMPLATE_PATH . '/assets/vendor.css');
$asset->addCss(SITE_TEMPLATE_PATH . '/assets/app.min.css');
$asset->addJs(SITE_TEMPLATE_PATH . '/assets/app.min.js', true);
$header = \dnext\Models\Home\Settings::instance()->getFirstCached();
?>
<!DOCTYPE HTML>
<html lang="<?= LANGUAGE_ID ?>">
<head>
    <meta charset="<?= LANG_CHARSET ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="author" content="Контент">
    <meta name="keywords" content="keywords">
    <meta name="description" content="description">

    <title><?php $APPLICATION->ShowTitle(); ?></title>
    <?php $APPLICATION->ShowHead(); ?>
    <meta property="og:title" content="<?php $APPLICATION->ShowTitle(); ?>"/>
    <meta property="og:description" content="<?php $APPLICATION->ShowProperty('description', ''); ?>"/>
    <meta property="og:image" content="<?= 'http://' . SITE_SERVER_NAME . '/' . SITE_TEMPLATE_PATH . '/favicon.png' ?>">
    <?php if ($USER->IsAdmin()): ?>
        <?php //$APPLICATION->ShowPanel(); ?>
    <?php endif; ?>
    <? $APPLICATION->ShowCSS(); ?>
</head>
<body>

<header class="header" data-header>
    <div class="header__wrap">
        <div class="container header__container">
            <div class="header__mtoggle">
                <a href="#" class="mtoggle" data-mtoggle>
                    <span class="mtoggle__icon"></span>
                </a>
            </div>

            <div class="header__brand">
                <a href="/" class="brand">
                    <img src="<?= \dnext\Helpers\FilesHelper::getImageById($header['LOGOTYPE_HEADER']['VALUE']) ?>"
                         alt="{$smarty.const.SITE_NAME}"
                         class="brand__img">
                </a>
            </div>

            <div class="spacer"></div>

            <div class="header__nav">
                <nav class="mnav" data-nav>
                    <div class="mnav__wrap">
                        <div class="mnav__menu">
                            <ul class="main-menu">

                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:menu",
                                    "top",
                                    Array(
                                        "ALLOW_MULTI_SELECT" => "N",
                                        "CHILD_MENU_TYPE" => "",
                                        "DELAY" => "N",
                                        "MAX_LEVEL" => "1",
                                        "MENU_CACHE_GET_VARS" => array(""),
                                        "MENU_CACHE_TIME" => "3600",
                                        "MENU_CACHE_TYPE" => "N",
                                        "MENU_CACHE_USE_GROUPS" => "Y",
                                        "ROOT_MENU_TYPE" => "top",
                                        "USE_EXT" => "N"
                                    )
                                );?>


                                <a href="/#buy" class="btn btn_brd mnav__btn"><?= $header['BUTTON_TEXT_HEADER']['VALUE'] ?></a>



                            </ul>

                        </div>

                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>

<div class="wrapper">
