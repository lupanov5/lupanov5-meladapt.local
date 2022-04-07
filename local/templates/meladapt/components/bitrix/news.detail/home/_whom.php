<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * @var $arResult
 * @global CMain $APPLICATION
 */
?>

<section class="whom">

    <div class="container whom__container">
        <div class="whom__bg wow-slideLeft" data-animate="slideLeft">
            <?php foreach ($arResult['PROPERTIES']['BACKGROUND_IMAGE_WHOM']['VALUE'] as $imageID): ?>
                <img src="<?= \dnext\Helpers\FilesHelper::getImageById($imageID) ?>" alt="">
            <?php endforeach; ?>
        </div>

        <div class="whom__head">
            <h1 class=whom__title"><?= $arResult['PROPERTIES']['TITLE_WHOM']['VALUE'] ?></h1>
        </div>

        <div class="whom__list">
            <?php if (!empty($arResult['PROPERTIES']['DESC_1_WHOM']['VALUE'])): ?>
                <div class="whom__item">
                    <svg class="icon">
                        <use xlink:href="#icon-arr-right"></use>
                    </svg>
                    <span>
                    <?= $arResult['PROPERTIES']['DESC_1_WHOM']['VALUE'] ?>
                </span>
                </div>
            <?php endif; ?>
            <?php if (!empty($arResult['PROPERTIES']['DESC_2_WHOM']['VALUE'])): ?>
                <div class="whom__item">
                    <svg class="icon">
                        <use xlink:href="#icon-arr-right"></use>
                    </svg>
                    <span>
                    <?= $arResult['PROPERTIES']['DESC_2_WHOM']['VALUE'] ?>
                </span>
                </div>
            <?php endif; ?>
            <?php if (!empty($arResult['PROPERTIES']['DESC_3_WHOM']['VALUE'])): ?>
                <div class="whom__item">
                    <svg class="icon">
                        <use xlink:href="#icon-arr-right"></use>
                    </svg>
                    <span>
                    <?= $arResult['PROPERTIES']['DESC_3_WHOM']['VALUE'] ?>
                </span>
                </div>
            <?php endif; ?>
            <?php if (!empty($arResult['PROPERTIES']['DESC_4_WHOM']['VALUE'])): ?>
                <div class="whom__item">
                    <svg class="icon">
                        <use xlink:href="#icon-arr-right"></use>
                    </svg>
                    <span>
                    <?= $arResult['PROPERTIES']['DESC_4_WHOM']['VALUE'] ?>
                </span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

