<?php


namespace dnext\CustomProperties;


class PropertyTitleText
{
    public function GetUserTypeDescription()
    {
        return array(
            "PROPERTY_TYPE"        => "S", #-----один из стандартных типов
            "USER_TYPE"            => "NX_TITLE_VALUE", #-----идентификатор типа свойства
            "DESCRIPTION"          => "Заголовок-значение",
            "GetPropertyFieldHtml" => ["dnext\CustomProperties\PropertyTitleText", "GetPropertyFieldHtml"],
        );
    }

    /*--------- вывод поля свойства на странице редактирования ---------*/
    public function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        return '
        <input placeholder="Заголовок" type="text" name="'.$strHTMLControlName["DESCRIPTION"].'" value="'.$value['DESCRIPTION'].'">
        <input placeholder="Значение" size="70" type="text" name="'.$strHTMLControlName["VALUE"].'" value="'.$value['VALUE'].'">
        ';
    }
}