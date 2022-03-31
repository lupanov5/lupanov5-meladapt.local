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
                <a href="#"
                   class="btn btn_lt promo__btn"><?= $arResult['PROPERTIES']['BUTTON_TEXT_PROMO']['VALUE'] ?></a>
            <?php endif; ?>
            <?php if (!empty($arResult['PROPERTIES']['LINK_TEXT_PROMO']['VALUE']) && !empty($arResult['PROPERTIES']['FILE_PROMO']['VALUE'])): ?>
                <a href="<?= $a = \dnext\Helpers\FilesHelper::getFilePathById($arResult['PROPERTIES']['FILE_PROMO']['VALUE'])['PATH'] ?>"
                   class="link promo__instr">
                    <span><?= $arResult['PROPERTIES']['LINK_TEXT_PROMO']['VALUE'] ?></span>
                    <svg class="icon">
                        <use xlink:href="#icon-arr-white"></use>
                    </svg>
                </a>
            <?php endif; ?>
        </div>

    </div>

</section>

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

<section class="melatonin">
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

<section class="whom">

    <div class="container whom__container">
        <div class="whom__bg">
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

<section class="use">

    <div class="container use__container">

        <div class="use-picture">
            <div class="use__bg">
                <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['BACKGROUND_IMAGE_USE']['VALUE']) ?>"
                     alt="">
            </div>
            <div class="use-picture__head">
                <span class="use-picture__head_item active"><?= $arResult['PROPERTIES']['DESC_1_USE']['VALUE'] ?></span>
                <span class="use-picture__head_item"><?= $arResult['PROPERTIES']['DESC_2_USE']['VALUE'] ?></span>
            </div>
            <div class="use-picture__img">
                <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['PROPERTIES']['PRODUCT_IMAGE_USE']['VALUE']) ?>"
                     alt="pack">
            </div>
            <h4 class="use-picture__bottom"><?= $arResult['PROPERTIES']['DESC_3_USE']['~VALUE']['TEXT'] ?></h4>
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
                <a href="<?= $a = \dnext\Helpers\FilesHelper::getFilePathById($arResult['PROPERTIES']['FILE_PROMO']['VALUE'])['PATH'] ?>"
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
