<?php

namespace dnext\Helpers;

use CUser;
use CMain;
use CAllUser;
use CAllMain;
use CEventLog;
use Bitrix\Main\Loader;
use Bitrix\Main\EventManager;
use Bitrix\Main\LoaderException;

class ApplicationHelper
{
    /**
     * Получить экземпляр пользователя
     *
     * @return CAllUser|CUser
     */
    public static function getUser()
    {
        global $USER;

        return $USER;
    }

    /**
     * Получить экзеспляр битрикс приложения
     *
     * @return CAllMain|CMain
     */
    public static function getApp()
    {
        global $APPLICATION;

        return $APPLICATION;
    }

    /**
     * Добавление нескольких событий
     *
     * @param array $events
     */
    public static function addEvents(array $events = []): void
    {
        foreach ($events as $event) {
            EventManager::getInstance()->addEventHandler($event['module'], $event['type'], $event['callback']);
        }
    }

    /**
     * Массовое включение модулей
     *
     * @param string[] $modules
     */
    public static function includeModules(array $modules): void
    {
        try {
            foreach ($modules as $module) {
                Loader::includeModule($module);
            }
        } catch (LoaderException $e) {
            CEventLog::Log(
                CEventLog::SEVERITY_ERROR,
                '',
                '',
                '',
                $e->getMessage()
            );
        }
    }

    /**
     * Установка метатегов
     *
     * @param string|null $title
     * @param string|null $keywords
     * @param string|null $description
     */
    public static function setMetaTags(?string $title = '', ?string $keywords = '', ?string $description = ''): void
    {
        $app = self::getApp();
        $app->SetTitle($title);
        $app->SetPageProperty("keywords", $keywords);
        $app->SetPageProperty("description", $description);
    }

    /**
     * Инициализация инфоблоков с одним элементом
     *
     * @param array $elements
     */
    public static function initOneBlockElements(array $elements = []): void
    {
        $config = include $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/configs/config.php';

        if ($config['ON_ONE_IBLOCKS']) {
            foreach ($elements as $element) {
                try {
                    new $element;
                } catch (\Exception $e) {
                    LogHelper::error($e->getMessage());
                }
            }
        }
    }

    public static function isAdminArea()
    {
        return strripos(ApplicationHelper::getApp()->GetCurDir(), '/bitrix/') !== false;
    }
}
