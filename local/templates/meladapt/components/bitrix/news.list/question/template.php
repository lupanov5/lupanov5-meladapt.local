<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * @var $arResult
 * @global CMain $APPLICATION
 */
?>
<section class="container questions">
    <div class="questions__decor">
        <?php foreach ($arResult['SETTINGS_PAGE']['IMAGES']['VALUE'] as $image): ?>
            <img src="<?= \dnext\Helpers\FilesHelper::getImageById($image) ?>" alt="">
        <?php endforeach; ?>
    </div>
    <div class="content-narrow">
        <div class="questions__title">
            <h1><?= $arResult['SETTINGS_PAGE']['TITLE_PART_1']['VALUE'] ?>
                <span><?= $arResult['SETTINGS_PAGE']['TITLE_PART_2']['VALUE'] ?></span>
            </h1>
        </div>

        <ul class="questions__accordion" data-load-content>
            <?php foreach ($arResult['ITEMS'] as $key => $arItem): ?>
                <?php if (!empty($arItem['~PREVIEW_TEXT'])): ?>
                    <li class="questions__item">
                        <div class="questions__item_question" data-tab-btn="qw-<?= $key ?>">
                            <span><?= $arItem['NAME'] ?></span>

                        </div>
                        <div class="questions__item_answer" data-tab-content="qw-<?= $key ?>">
                            <p><?= $arItem['~PREVIEW_TEXT'] ?></p>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
        <?php if (!empty($arResult['SETTINGS_PAGE']['BUTTON_TEXT_QUESTION']['VALUE'])): ?>
            <div class="questions__buttons">
                <a href="#" class="btn questions__btn" data-custom-open="question"><span><?= $arResult['SETTINGS_PAGE']['BUTTON_TEXT_QUESTION']['VALUE'] ?></span></a>
            </div>
        <?php endif; ?>
    </div>
</section>
