<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * @var $arResult
 * @global CMain $APPLICATION
 */
?>

<section class="use">

    <div class="container use__container">

        <div class="use-picture">
            <div class="use__bg">
                <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['BACKGROUND_IMAGE_USE']['VALUE']) ?>"
                     alt="">
            </div>
            <div class="use-picture__head">
                <span data-use-btn="10" class="use-picture__head_item active"><?= $arResult['PROPERTIES']['TAB_1_USE']['VALUE'] ?></span>
                <span data-use-btn="30" class="use-picture__head_item"><?= $arResult['PROPERTIES']['TAB_2_USE']['VALUE'] ?></span>
            </div>
            <div data-use-content="10" class="use-picture__block active">
                <img class="use-picture__img" src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['PRODUCT_1_IMAGE_USE']['VALUE']) ?>"
                     alt="pack">
                <h4 class="use-picture__bottom"><?= $arResult['PROPERTIES']['DESC_1_USE']['~VALUE']['TEXT'] ?></h4>
            </div>
            <div data-use-content="30" class="use-picture__block">
                <img class="use-picture__img" src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['PRODUCT_2_IMAGE_USE']['VALUE']) ?>"
                     alt="pack">
                <h4 class="use-picture__bottom"><?= $arResult['PROPERTIES']['DESC_2_USE']['~VALUE']['TEXT'] ?></h4>
            </div>
        </div>

        <div class="use__head">
            <h1 class=use__title"><?= $arResult['PROPERTIES']['TITLE_USE']['VALUE'] ?></h1>
            <div class="use__subtitle">
                <?= $arResult['PROPERTIES']['DESC_4_USE']['~VALUE']['TEXT'] ?>
            </div>
            <div class="use-tablet">
                <?php if (!empty($arResult['PROPERTIES']['NUM_1_USE']['VALUE']) && !empty($arResult['PROPERTIES']['DESC_5_USE']['~VALUE']['TEXT'])): ?>
                    <div class="use-tablet__item">
                        <div class="use-tablet__img">
                            <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['IMAGE_1_USE']['VALUE']) ?>"
                                 alt="">
                        </div>
                        <div class="use-tablet__number"><?= $arResult['PROPERTIES']['NUM_1_USE']['VALUE'] ?></div>
                        <div class="use-tablet__descr">
                            <?= $arResult['PROPERTIES']['DESC_5_USE']['~VALUE']['TEXT'] ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($arResult['PROPERTIES']['NUM_2_USE']['VALUE']) && !empty($arResult['PROPERTIES']['DESC_6_USE']['~VALUE']['TEXT'])): ?>
                    <div class="use-tablet__item">
                        <div class="use-tablet__img">
                            <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['IMAGE_2_USE']['VALUE']) ?>"
                                 alt="">
                        </div>
                        <div class="use-tablet__number"><?= $arResult['PROPERTIES']['NUM_2_USE']['VALUE'] ?></div>
                        <div class="use-tablet__descr">
                            <?= $arResult['PROPERTIES']['DESC_6_USE']['~VALUE']['TEXT'] ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (!empty($arResult['PROPERTIES']['LINK_TEXT_PROMO']['VALUE']) && !empty($arResult['PROPERTIES']['FILE_PROMO']['VALUE'])): ?>
                <a href="<?= \dnext\Helpers\FilesHelper::getFilePathById($arResult['PROPERTIES']['FILE_PROMO']['VALUE'])['PATH'] ?>"
                   class="link use__instr">
                    <span><?= $arResult['PROPERTIES']['LINK_TEXT_PROMO']['VALUE'] ?></span>
                    <svg class="icon">
                        <use xlink:href="#icon-arrow-down"></use>
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </div>

</section>


