<?php
AddEventHandler("iblock", "OnIBlockPropertyBuildList", [
    "dnext\CustomProperties\PropertyTime", "GetUserTypeDescription",
]);
AddEventHandler("iblock", "OnIBlockPropertyBuildList", [
    "dnext\CustomProperties\PropertyTitleText", "GetUserTypeDescription",
]);
AddEventHandler("iblock", "OnIBlockPropertyBuildList", [
    "dnext\CustomProperties\PropertyColor", "GetUserTypeDescription",
]);
AddEventHandler("iblock", "OnIBlockPropertyBuildList", [
    "dnext\CustomProperties\PropertySocialNetworks", "GetUserTypeDescription",
]);
/** убрать рекламу в админке */
AddEventHandler('main','OnAdminTabControlBegin','RemoveYandexDirectTab');
function RemoveYandexDirectTab(&$TabControl){
    if ($GLOBALS['APPLICATION']->GetCurPage() === '/bitrix/admin/iblock_element_edit.php') {
        foreach($TabControl->tabs as $Key => $arTab){
            if($arTab['DIV'] === 'seo_adv_seo_adv') {
                unset($TabControl->tabs[$Key]);
            }
        }
    }
}

