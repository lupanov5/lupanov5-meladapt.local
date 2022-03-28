<?php

namespace dnext\Helpers;
use Bitrix\Main;
use Bitrix\Main\Loader;
use Bitrix\Main\Security;

class ElementsHelper
{
    /**
     * Возвращает элемент по его id
     * вместе со свойствами
     *
     * @param null $id
     * @return array|false
     */
    public static function getElementById($id = null)
    {
        $result = false;

        if(!\CModule::IncludeModule("iblock")) return $result;

        $res = \CIBlockElement::GetByID($id);
        if($el = $res->GetNextElement()) {
            $result = $el->GetFields() + $el->GetProperties();
        }

        return $result;
    }

    /**
     * На входе получает свойство целиком
     * из полей ~VALUE & DESCRIPTION создает массив файл-описание
     * @param $array
     * @return array
     */
    public static function valueDescription($array)
    {
        $result = [];
        if(!empty($array['VALUE'] && !empty($array['DESCRIPTION']))) {
            foreach ($array['~VALUE'] as $key => $value) {
                if(!empty($array['DESCRIPTION'][$key])) {
                    $description = $array['DESCRIPTION'][$key];
                } else {
                    $description = null;
                }
                $result[$key] = [
                    'VALUE' => $value,
                    'DESCRIPTION' => $description
                ];
            }
        }

        return $result;
    }

    /**
     * Создает символьный код по имени
     *
     * @param $name
     * @return string
     */
    public static function codeGenerator($name)
    {
        $arTransParams = array(
            "max_len" => 100,
            "change_case" => 'L', // 'L' - toLower, 'U' - toUpper, false - do not change
            "replace_space" => '-',
            "replace_other" => '-',
            "delete_repeat_replace" => true
        );

        return \CUtil::translit($name, "ru", $arTransParams);
    }
}