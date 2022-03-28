<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * @var $arResult
 * @global CMain $APPLICATION
 */
?>

<section class="buy">
    <div class="container buy__container">

        <div class="buy__head">
            <h1 class=buy__title"><?= $arResult['SETTINGS_PAGE']['TITLE_BUY']['VALUE'] ?></h1>
            <div class="buy__subtitle"><?= $arResult['SETTINGS_PAGE']['DESC_BUY']['~VALUE']['TEXT'] ?></div>
        </div>

        <ul class="buy__list list" data-load-content>
            <?php foreach ($arResult['ITEMS'] as $arItem): ?>
                <?php if (!empty($arItem['PREVIEW_PICTURE']['ID']) && !empty($arItem['PROPERTIES']['LINK']['VALUE'])): ?>
                    <li class="list__item list__item_shop">
                        <a href="<?= $arItem['PROPERTIES']['LINK']['VALUE'] ?>" class="list__item_link">
                            <div class="list__head list__head_shop">
                                <img src="<?= \dnext\Helpers\FilesHelper::getImageById($arItem['PREVIEW_PICTURE']['ID']) ?>"
                                     alt="shop">
                            </div>
                            <div class="list__title list__title_shop"><?= $arItem['NAME'] ?></div>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
        <?php if (!empty($arResult['SETTINGS_PAGE']['TEXT_LINK_BUY']['VALUE']) && $arResult['NAV_RESULT']->NavRecordCount > BUY_SHOWBY): ?>
            <a href="" class="link buy__show" data-show-more="1" data-show-more-url="/request/index.php?PAGEN_1=2&COUNTREC=<?= $arResult['NAV_RESULT']->NavRecordCount; ?>">
                <span><?= $arResult['SETTINGS_PAGE']['TEXT_LINK_BUY']['VALUE'] ?></span>
            </a>
        <?php endif; ?>
    </div>

</section>