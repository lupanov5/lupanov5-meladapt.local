<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * @var $arResult
 * @global CMain $APPLICATION
 */
?>
<?php foreach ($arResult as $item): ?>
<li class="main-menu__el" data-menu-el>
    <a href="<?= $item['LINK'] ?>" class="main-menu__link">
        <span><?= $item['TEXT'] ?></span>
    </a>
</li>
<?php endforeach; ?>

