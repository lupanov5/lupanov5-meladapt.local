<?php


namespace dnext\CustomProperties;

use dnext\Helpers\SocialsHelper;

/**
 * Сохраняет ссылку на соцсеть в VALUE и код соцсети в DESCRIPTION
 * Class PropertySocialNetworks
 * @package dnext\CustomProperties
 */
class PropertySocialNetworks
{
    public function GetUserTypeDescription()
    {
        return array(
            "PROPERTY_TYPE"        => "S", #-----один из стандартных типов
            "USER_TYPE"            => "NX_TITLE_TEXT", #-----идентификатор типа свойства
            "DESCRIPTION"          => "Соцсети",
            "GetPropertyFieldHtml" => ["dnext\CustomProperties\PropertySocialNetworks", "GetPropertyFieldHtml"],
        );
    }

    /*--------- вывод поля свойства на странице редактирования ---------*/
    public function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        $networks = self::getSocialNetworks();

        $html = '<select name="'.$strHTMLControlName["DESCRIPTION"].'">';
        $html .= '<option value=""></option>';
        foreach ($networks as $key => $network) {
            $selected = '';
            if($key == $value['DESCRIPTION']) $selected = 'selected';

            $html .= '<option ' . $selected .' value="' . $key . '">' . $network['title'] . '</option>';
        }
        $html .= '</select>';
        $html .= '<input placeholder="Ссылка" size="50" type="text" name="'.$strHTMLControlName["VALUE"].'" value="'.$value['VALUE'].'">
        ';

        return $html;
    }

    /**
     * @return array[]
     */
    public static function getSocialNetworks()
    {
        try {
            if(class_exists('dnext\Helpers\SocialsHelper')){
                $result = SocialsHelper::getSocialNetworks();
            } else {
                throw new \Exception('Метод не найден');
            }

        } catch (\Exception $e) {
            $result = [
                '0' => [
                    'title' => 'не установлены',
                    'svg' => ''
                ]
            ];
        }

        return $result;
    }
}