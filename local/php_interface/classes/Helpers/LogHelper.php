<?php

namespace dnext\Helpers;

use CEventLog;

/**
 * Class LogHelper
 * @package dnext\helpers
 */
class LogHelper
{
    const AUDIT_TYPE = 'dnext-custom';

    public static function error(string $description, $moduleId = 'UNKNOWN', $itemId = 'UNKNOWN'): void
    {
        CEventLog::Log(
            CEventLog::SEVERITY_ERROR,
            self::AUDIT_TYPE,
            $moduleId,
            $itemId,
            $description
        );
    }

    public static function warning(string $description, $moduleId = 'UNKNOWN', $itemId = 'UNKNOWN'): void
    {
        CEventLog::Log(
            CEventLog::SEVERITY_WARNING,
            self::AUDIT_TYPE,
            $moduleId,
            $itemId,
            $description
        );
    }

    public static function info(string $description, $moduleId = 'UNKNOWN', $itemId = 'UNKNOWN'): void
    {
        CEventLog::Log(
            CEventLog::SEVERITY_INFO ,
            self::AUDIT_TYPE,
            $moduleId,
            $itemId,
            $description
        );
    }

    public static function debug(string $description, $moduleId = 'UNKNOWN', $itemId = 'UNKNOWN'): void
    {
        CEventLog::Log(
            CEventLog::SEVERITY_DEBUG,
            self::AUDIT_TYPE,
            $moduleId,
            $itemId,
            $description
        );
    }

    public static function security(string $description, $moduleId = 'UNKNOWN', $itemId = 'UNKNOWN'): void
    {
        CEventLog::Log(
            CEventLog::SEVERITY_SECURITY,
            self::AUDIT_TYPE,
            $moduleId,
            $itemId,
            $description
        );
    }
}
