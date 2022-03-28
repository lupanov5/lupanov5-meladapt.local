<?php


namespace dnext\CustomProperties;


class PropertyTime
{
    public function GetUserTypeDescription()
    {
        return array(
            "PROPERTY_TYPE"        => "S", #-----один из стандартных типов
            "USER_TYPE"            => "NX_TIME", #-----идентификатор типа свойства
            "DESCRIPTION"          => "Время",
            "GetPropertyFieldHtml" => ["dnext\CustomProperties\PropertyTime", "GetPropertyFieldHtml"],
        );
    }

    /*--------- вывод поля свойства на странице редактирования ---------*/
    public function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        return '<input type="time" name="'.$strHTMLControlName["VALUE"].'" value="'.$value['VALUE'].'">';
    }
}