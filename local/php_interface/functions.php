<?
/**
 * Created by PhpStorm.
 * User: Alexeenko Sergey Aleksandrovich
 * Phone: +79231421947
 * Email: sergei_alekseenk@list.ru
 * Date: 01.06.2019
 * Time: 11:37
 */

/**
 * Вывод дампа переменной и останов
 */
if (!function_exists('dd')) {
    function dd($var) {
        \dnext\Helpers\FilesHelper::dd($var);
        die;
    }
}

/**
 * Вывод дампа переменной с продолжением выполнения
 */
if (!function_exists('dnd')) {
    function dnd($var)
    {
        \dnext\Helpers\FilesHelper::dd($var);
    }
}

/**
 * Установка статуса 404
 */
if (!function_exists('set404')) {
    function set404() {
        global $APPLICATION;
        CHTTP::SetStatus("404 Not Found");
        @define("ERROR_404","Y");
        define("HIDE_SIDEBAR", true);

        \Bitrix\Iblock\Component\Tools::process404(
            'Не найден', //Сообщение
            true, // Нужно ли определять 404-ю константу    true, // Устанавливать ли статус
            true, // Показывать ли 404-ю страницу
            false // Ссылка на отличную от стандартной 404-ю
        );
        if ($APPLICATION->RestartWorkarea()) {
            require(\Bitrix\Main\Application::getDocumentRoot()."/404.php");
            die();
        }
    }
}
