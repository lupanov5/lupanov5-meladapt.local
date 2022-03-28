<?php

@session_set_cookie_params(86400);
@ini_set('session.gc_maxlifetime', 86400);

/** Параметры отладки для подключённых компонентов */
$exceptionHandling = \Bitrix\Main\Config\Configuration::getValue('exception_handling');
define('DEBUG_ENABLE', $exceptionHandling['debug']);

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/vendor/autoload.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/local/vendor/autoload.php';
}

/** Отключаем Kint, если его использовали, все забытые в коде вызовы перестанут работать */
if (!DEBUG_ENABLE && class_exists('Kint\Kint')) {
    \Kint\Kint::$enabled_mode = false;
}

/** Отключаем кэширование компонентов при включённой отладке, чтобы не сбрасывать кэш */
if (DEBUG_ENABLE) {
//    COption::SetOptionString('main', 'component_cache_on', 'N');
}

/** Подключение констант проекта */
if (file_exists(__DIR__ . '/constants.php')) {
    require_once(__DIR__ . '/constants.php');
}

/** Подключение функций проекта */
if (file_exists(__DIR__ . '/functions.php')) {
    require_once(__DIR__ . '/functions.php');
}

/** Подключение обработчиков проекта */
if (file_exists(__DIR__ . '/events.php')) {
    require_once(__DIR__ . '/events.php');
}
