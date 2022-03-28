<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * @var $arResult
 * @global CMain $APPLICATION
 */
?>
<section class="container questions_main">
    <div class="questions__bg">
        <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arResult['SETTINGS_PAGE']['BACKGROUND_IMAGE_QUESTION']['VALUE']) ?>" alt="">
    </div>
    <div class="content-narrow">
        <div class="questions__title">
            <h1><?= $arResult['SETTINGS_PAGE']['TITLE_QUESTION']['VALUE'] ?><span><?= $arResult['SETTINGS_PAGE']['SUBTITLE_QUESTION']['VALUE'] ?></span></h1>
        </div>

        <ul class="questions__accordion">
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

        <div class="questions__buttons">
            <?php if (!empty($arResult['SETTINGS_PAGE']['TEXT_BUTTON_1_QUESTION']['VALUE'])): ?>
                <a href="#"
                   class="btn questions__btn"><span><?= $arResult['SETTINGS_PAGE']['TEXT_BUTTON_1_QUESTION']['VALUE'] ?></span></a>
            <?php endif; ?>
            <?php if (!empty($arResult['SETTINGS_PAGE']['TEXT_BUTTON_2_QUESTION']['VALUE'])): ?>
                <a href="/questions/"
                   class="btn btn_brd questions__btn"><span><?= $arResult['SETTINGS_PAGE']['TEXT_BUTTON_2_QUESTION']['VALUE'] ?></span></a>
            <?php endif; ?>
        </div>
    </div>
</section>