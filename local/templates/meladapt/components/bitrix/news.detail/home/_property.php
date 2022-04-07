<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * @var $arResult
 * @global CMain $APPLICATION
 */
?>


<section class="property">

    <div class="container property__container">

        <ul class="list property__list">
            <?php if (!empty($arResult['PROPERTIES']['IMAGE_1_FACT']['VALUE']) && !empty($arResult['PROPERTIES']['DESC_1_FACT']['~VALUE']['TEXT'])): ?>
                <li class="list__item">
                    <div class="list__head">
                        <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['IMAGE_1_FACT']['VALUE']) ?>"
                             alt="">
                    </div>
                    <div class="list__title"><?= $arResult['PROPERTIES']['DESC_1_FACT']['~VALUE']['TEXT'] ?>
                    </div>
                </li>
            <?php endif; ?>
            <?php if (!empty($arResult['PROPERTIES']['IMAGE_2_FACT']['VALUE']) && !empty($arResult['PROPERTIES']['DESC_2_FACT']['~VALUE']['TEXT'])): ?>
                <li class="list__item">
                    <div class="list__head">
                        <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['IMAGE_2_FACT']['VALUE']) ?>"
                             alt="">
                    </div>
                    <div class="list__title"><?= $arResult['PROPERTIES']['DESC_2_FACT']['~VALUE']['TEXT'] ?>
                    </div>
                </li>
            <?php endif; ?>
            <?php if (!empty($arResult['PROPERTIES']['IMAGE_3_FACT']['VALUE']) && !empty($arResult['PROPERTIES']['DESC_3_FACT']['~VALUE']['TEXT'])): ?>
                <li class="list__item">
                    <div class="list__head">
                        <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['IMAGE_3_FACT']['VALUE']) ?>"
                             alt="">
                    </div>
                    <div class="list__title"><?= $arResult['PROPERTIES']['DESC_3_FACT']['~VALUE']['TEXT'] ?>
                    </div>
                </li>
            <?php endif; ?>
            <?php if (!empty($arResult['PROPERTIES']['IMAGE_4_FACT']['VALUE']) && !empty($arResult['PROPERTIES']['DESC_4_FACT']['~VALUE']['TEXT'])): ?>
                <li class="list__item">
                    <div class="list__head">
                        <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['IMAGE_4_FACT']['VALUE']) ?>"
                             alt="">
                    </div>
                    <div class="list__title"><?= $arResult['PROPERTIES']['DESC_4_FACT']['~VALUE']['TEXT'] ?>
                    </div>
                </li>
            <?php endif; ?>
        </ul>

    </div>

</section>
