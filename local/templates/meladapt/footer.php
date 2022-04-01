<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 */
$footer = \dnext\Models\Home\Settings::instance()->getFirstCached();
?>
<footer class="footer">
    <div class="footer__bg">
        <img alt="cloud" src="<?= \dnext\Helpers\FilesHelper::getImageById($footer['BACKGROUND_IMAGE_FOOTER']['VALUE']) ?>">
    </div>
    <div class="footer__wrap container">
        <div class="flex-row footer__top">
            <div class="flex-col md-6 sm-24 footer__brand">
                <a href="/" class="brand"> <img alt="{$smarty.const.SITE_NAME}"
                                                src="<?= \dnext\Helpers\FilesHelper::getImageById($footer['LOGOTYPE_1_FOOTER']['VALUE']) ?>"
                                                class="brand__img"> </a>
            </div>
            <div class="flex-col md-12 sm-24 footer__menu">
                <ul class="main-menu">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "bottom",
                        Array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(""),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "bottom",
                            "USE_EXT" => "N"
                        )
                    );?>
                </ul>
            </div>
            <a href="<?= \dnext\Helpers\FilesHelper::getImageById($footer['FILE_PROMO']['VALUE']) ?>" class="flex-col md-6 sm-24 link footer__instruction">
                <?= $footer['TEXT_LINK_INSTRUCTION_FOOTER']['VALUE'] ?></a>
            <div class="flex-col md-24 footer__warning">
                <?= $footer['TEXT_LINK_CONTRA_FOOTER']['VALUE'] ?>
                <!--<img src="/local/templates/meladapt/assets/images/warning.png" alt="">-->
            </div>
        </div>
        <div class="footer__middle">
            <div class="footer__shop">
                <img alt="ozon" src="<?= \dnext\Helpers\FilesHelper::getImageById($footer['LOGOTYPE_2_FOOTER']['VALUE']) ?>">
            </div>
            <div class="footer__contacts">
                <div class="nx-contacts__item">
                    <div class="nx-contacts__label">
                        <?= $footer['PHONE_TITLE_FOOTER']['VALUE'] ?>
                    </div>
                    <a href="tel:<?= \dnext\Helpers\Generic::getCleanPhoneNumber($footer['PHONE_FOOTER']['VALUE']) ?>" class="nx-contacts__title"><?= $footer['PHONE_FOOTER']['VALUE'] ?></a>
                </div>
                <div class="nx-contacts__item">
                    <div class="nx-contacts__label">
                        <?= $footer['EMAIL_TITLE_FOOTER']['VALUE'] ?>
                    </div>
                    <a href="mailto:<?= $footer['EMAIL_FOOTER']['VALUE'] ?>" class="nx-contacts__title"><?= $footer['EMAIL_FOOTER']['VALUE'] ?></a>
                </div>
                <div class="nx-contacts__item">
                    <div class="nx-contacts__label">
                        <?= $footer['SITE_TITLE_FOOTER']['VALUE'] ?>
                    </div>
                    <a href="http://<?= $footer['SITE_FOOTER']['VALUE'] ?>" class="nx-contacts__title"><?= $footer['SITE_FOOTER']['VALUE'] ?></a>
                </div>
            </div>
        </div>
        <div class="footer__bottom">
            <div class="footer__politics" >
                © 2021 Фармацевтическая компания «ОЗОН», <a href="#" class="footer__politics link" target="_blank" rel="noopener">
                    <?= $footer['TEXT_COPYRIGHT_FOOTER']['VALUE'] ?></a>
            </div>
            <a href="#" class="footer__link link" target="_blank" rel="noopener"><?= $footer['TEXT_PERSONAL_DATA_FOOTER']['VALUE'] ?></a>
            <div class="footer__dnext">
                Разработка сайта — <a href="https://dnext.ru/" class="link" target="_blank" rel="noopener">
                    Next </a>
            </div>
        </div>
    </div>
</footer>
<!--<script src="/local/templates/meladapt/assets/app.min.js"></script>-->