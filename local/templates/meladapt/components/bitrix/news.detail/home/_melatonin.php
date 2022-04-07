<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * @var $arResult
 * @global CMain $APPLICATION
 */
?>

<section id="about" class="melatonin">
    <div class="container melatonin__container">
        <div class="melatonin__bg">
            <?php foreach ($arResult['PROPERTIES']['BACKGROUND_IMAGE_WHY']['VALUE'] as $image): ?>
                <img src="<?= \dnext\Helpers\FilesHelper::getImageById($image) ?>" alt="">
            <?php endforeach; ?>
        </div>
        <div class="melatonin__content">
            <div class="promo__head">
                <h1 class="promo__title">
                    <?= $arResult['PROPERTIES']['TITLE_WHY']['VALUE'] ?>
                    <span><?= $arResult['PROPERTIES']['SUBTITLE_WHY']['VALUE'] ?></span>
                </h1>
                <div class="promo__subtitle">
                    <?= $arResult['PROPERTIES']['DESC_WHY']['~VALUE']['TEXT'] ?>
                </div>
            </div>

            <div class="feat melatonin__feat">
                <?php if (!empty($arResult['PROPERTIES']['ICON_1_WHY']['VALUE']) && !empty($arResult['PROPERTIES']['DESC_1_WHY']['VALUE'])): ?>
                    <div class="feat__item fadeIn">
                        <div class="feat__img">
                            <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['ICON_1_WHY']['VALUE']) ?>"
                                 alt="Features">
                        </div>
                        <div class="feat__text">
                            <?= $arResult['PROPERTIES']['DESC_1_WHY']['VALUE'] ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($arResult['PROPERTIES']['ICON_2_WHY']['VALUE']) && !empty($arResult['PROPERTIES']['DESC_2_WHY']['VALUE'])): ?>
                    <div class="feat__item fadeIn">
                        <div class="feat__img">
                            <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['ICON_2_WHY']['VALUE']) ?>"
                                 alt="Features">
                        </div>
                        <div class="feat__text">
                            <?= $arResult['PROPERTIES']['DESC_2_WHY']['VALUE'] ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($arResult['PROPERTIES']['ICON_3_WHY']['VALUE']) && !empty($arResult['PROPERTIES']['DESC_3_WHY']['VALUE'])): ?>
                    <div class="feat__item fadeIn">
                        <div class="feat__img">
                            <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['ICON_3_WHY']['VALUE']) ?>"
                                 alt="Features">
                        </div>
                        <div class="feat__text">
                            <?= $arResult['PROPERTIES']['DESC_3_WHY']['VALUE'] ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($arResult['PROPERTIES']['ICON_4_WHY']['VALUE']) && !empty($arResult['PROPERTIES']['DESC_4_WHY']['VALUE'])): ?>
                    <div class="feat__item fadeIn">
                        <div class="feat__img">
                            <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['ICON_4_WHY']['VALUE']) ?>"
                                 alt="Features">
                        </div>
                        <div class="feat__text">
                            <?= $arResult['PROPERTIES']['DESC_4_WHY']['VALUE'] ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

