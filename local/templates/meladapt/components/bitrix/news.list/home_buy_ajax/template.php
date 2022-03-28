<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * @var $arResult
 * @global CMain $APPLICATION
 */
?>

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
