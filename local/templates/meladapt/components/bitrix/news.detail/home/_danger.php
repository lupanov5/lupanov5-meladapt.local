<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * @var $arResult
 * @global CMain $APPLICATION
 */
?>


<section class="danger">

    <div class="container danger__container">
        <div class="danger__bg">
            <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['BACKGROUND_IMAGE_DANGER']['VALUE']) ?>"
                 alt="">
        </div>
        <div class="danger__block">
            <?php if (!empty($arResult['PROPERTIES']['ICON_1_DANGER']['VALUE']) && !empty($arResult['PROPERTIES']['DESC_1_DANGER']['VALUE'])): ?>
                <div class="danger__item">
                    <div class="danger__img">
                        <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['ICON_1_DANGER']['VALUE']) ?>"
                             alt="">
                    </div>
                    <div class="danger__text"><?= $arResult['PROPERTIES']['DESC_1_DANGER']['VALUE'] ?></div>
                </div>
            <?php endif; ?>
            <?php if (!empty($arResult['PROPERTIES']['ICON_2_DANGER']['VALUE']) && !empty($arResult['PROPERTIES']['DESC_2_DANGER']['VALUE'])): ?>
                <div class="danger__item">
                    <div class="danger__img">
                        <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['ICON_2_DANGER']['VALUE']) ?>"
                             alt="">
                    </div>
                    <div class="danger__text"><?= $arResult['PROPERTIES']['DESC_2_DANGER']['VALUE'] ?></div>
                </div>
            <?php endif; ?>
            <?php if (!empty($arResult['PROPERTIES']['ICON_3_DANGER']['VALUE']) && !empty($arResult['PROPERTIES']['DESC_3_DANGER']['VALUE'])): ?>
                <div class="danger__item">
                    <div class="danger__img">
                        <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['ICON_3_DANGER']['VALUE']) ?>"
                             alt="">
                    </div>
                    <div class="danger__text"><?= $arResult['PROPERTIES']['DESC_3_DANGER']['VALUE'] ?></div>
                </div>
            <?php endif; ?>
            <?php if (!empty($arResult['PROPERTIES']['ICON_4_DANGER']['VALUE']) && !empty($arResult['PROPERTIES']['DESC_4_DANGER']['VALUE'])): ?>
                <div class="danger__item">
                    <div class="danger__img">
                        <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['ICON_4_DANGER']['VALUE']) ?>"
                             alt="">
                    </div>
                    <div class="danger__text"><?= $arResult['PROPERTIES']['DESC_4_DANGER']['VALUE'] ?></div>
                </div>
            <?php endif; ?>
            <?php if (!empty($arResult['PROPERTIES']['ICON_5_DANGER']['VALUE']) && !empty($arResult['PROPERTIES']['DESC_5_DANGER']['VALUE'])): ?>
                <div class="danger__item">
                    <div class="danger__img">
                        <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['ICON_5_DANGER']['VALUE']) ?>"
                             alt="">
                    </div>
                    <div class="danger__text"><?= $arResult['PROPERTIES']['DESC_5_DANGER']['VALUE'] ?></div>
                </div>
            <?php endif; ?>
            <?php if (!empty($arResult['PROPERTIES']['ICON_6_DANGER']['VALUE']) && !empty($arResult['PROPERTIES']['DESC_6_DANGER']['VALUE'])): ?>
                <div class="danger__item">
                    <div class="danger__img">
                        <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['ICON_6_DANGER']['VALUE']) ?>"
                             alt="">
                    </div>
                    <div class="danger__text"><?= $arResult['PROPERTIES']['DESC_6_DANGER']['VALUE'] ?></div>
                </div>
            <?php endif; ?>
        </div>
        <div class="danger__head">
            <h1 class=danger__title"><?= $arResult['PROPERTIES']['TITLE_DANGER']['VALUE'] ?></h1>
        </div>
    </div>
</section>

