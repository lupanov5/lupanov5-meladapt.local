<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * @var $arResult
 * @global CMain $APPLICATION
 */
?>
<section class="promo">

    <div class="container">
        <div class="promo__bg-right">
            <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['BACKGROUND_IMAGE_1_PROMO']['VALUE']) ?>"
                 alt="">
        </div>
        <div class="promo__bg-left">
            <?php foreach ($arResult['PROPERTIES']['BACKGROUND_IMAGES_2_PROMO']['VALUE'] as $image): ?>
                <img src="<?= \dnext\Helpers\FilesHelper::getImageById($image) ?>" alt="">
            <? endforeach; ?>
        </div>
        <div class="promo__head">
            <h1 class=promo__title"><?= $arResult['PROPERTIES']['TITLE_PROMO']['VALUE'] ?>
                <span><?= $arResult['PROPERTIES']['SUBTITLE_PROMO']['VALUE'] ?></span>
            </h1>
        </div>

        <div class="promo__product">
            <div class="inner">
                <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['PRODUCT_IMAGE_PROMO']['VALUE']) ?>"
                     alt="">
            </div>
        </div>

        <div class="promo__feat feat">
            <?php if (!empty($arResult['PROPERTIES']['ICON_1_PROMO']['VALUE']) && !empty($arResult['PROPERTIES']['DESC_1_PROMO']['VALUE'])): ?>
                <div class="feat__item fadeIn">
                    <div class="feat__img">
                        <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['ICON_1_PROMO']['VALUE']) ?>"
                             alt="Features">
                    </div>
                    <div class="feat__text"><?= $arResult['PROPERTIES']['DESC_1_PROMO']['VALUE'] ?></div>
                </div>
            <?php endif; ?>
            <?php if (!empty($arResult['PROPERTIES']['ICON_2_PROMO']['VALUE']) && !empty($arResult['PROPERTIES']['DESC_2_PROMO']['VALUE'])): ?>
                <div class="feat__item fadeIn">
                    <div class="feat__img">
                        <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['ICON_2_PROMO']['VALUE']) ?>"
                             alt="Features">
                    </div>
                    <div class="feat__text"><?= $arResult['PROPERTIES']['DESC_2_PROMO']['VALUE'] ?></div>
                </div>
            <?php endif; ?>
            <?php if (!empty($arResult['PROPERTIES']['ICON_3_PROMO']['VALUE']) && !empty($arResult['PROPERTIES']['DESC_3_PROMO']['VALUE'])): ?>
                <div class="feat__item fadeIn">
                    <div class="feat__img">
                        <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['ICON_3_PROMO']['VALUE']) ?>"
                             alt="Features">
                    </div>
                    <div class="feat__text"><?= $arResult['PROPERTIES']['DESC_3_PROMO']['VALUE'] ?></div>
                </div>
            <?php endif; ?>
        </div>

        <div class="promo__bottom">
            <?php if (!empty($arResult['PROPERTIES']['BUTTON_TEXT_PROMO']['VALUE'])): ?>
                <a href="/#buy"
                   class="btn btn_lt promo__btn"><?= $arResult['PROPERTIES']['BUTTON_TEXT_PROMO']['VALUE'] ?></a>
            <?php endif; ?>
            <?php if (!empty($arResult['PROPERTIES']['LINK_TEXT_PROMO']['VALUE']) && !empty($arResult['PROPERTIES']['FILE_PROMO']['VALUE'])): ?>
                <a href="<?= $a = \dnext\Helpers\FilesHelper::getFilePathById($arResult['PROPERTIES']['FILE_PROMO']['VALUE'])['PATH'] ?>"
                   class="link promo__instr" target="_blank">
                    <span><?= $arResult['PROPERTIES']['LINK_TEXT_PROMO']['VALUE'] ?></span>
                    <svg class="icon">
                        <use xlink:href="#icon-arr-white"></use>
                    </svg>
                </a>
            <?php endif; ?>
        </div>

    </div>

</section>
