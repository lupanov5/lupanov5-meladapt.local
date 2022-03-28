<?php


namespace dnext\CustomProperties;


class PropertyColor
{
    public function GetUserTypeDescription()
    {
        return array(
            "PROPERTY_TYPE"        => "S", #-----один из стандартных типов
            "USER_TYPE"            => "NX_COLOR", #-----идентификатор типа свойства
            "DESCRIPTION"          => "Цвет",
            "GetPropertyFieldHtml" => ["dnext\CustomProperties\PropertyColor", "GetPropertyFieldHtml"],
        );
    }

    /*--------- вывод поля свойства на странице редактирования ---------*/
    public function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        return '<input type="color" name="'.$strHTMLControlName["VALUE"].'" value="'.$value['VALUE'].'">';
    }
}