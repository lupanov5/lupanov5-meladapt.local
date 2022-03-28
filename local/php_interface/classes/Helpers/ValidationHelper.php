<?php

namespace dnext\Helpers;

/**
 * Class ValidationHelper
 * @package dnext\helpers
 */
class ValidationHelper
{
    /**
     * Проверка значения по правилу
     *
     * @param $value
     * @param $rule
     * @return bool
     */
    private static function checkRule($value, $rule): bool
    {
        if (empty($rule)) {
            return true;
        }

        return preg_match($rule["rule"], $value) === 1 ? true : false;
    }

    /**
     * Валидация
     *
     * @param array $values
     * @param array $validateRules
     * @return array
     */
    public static function validate(array $values, array $validateRules): array
    {
        $errors = [];
        foreach ($validateRules as $key => $item) {
            if ((empty($values[$key]) || !isset($values[$key])) && !empty($validateRules[$key]["presence"])) {
                $errors += [$key => $item['presence']];
            } else {
                if (!empty($validateRules[$key]["format"]) && !empty($values[$key])) {
                    if (self::checkRule($values[$key], $item['format'])) {
                        continue;
                    }

                    $errors += [$key => $item['format']['message']];
                }
            }
        }

        return $errors;
    }
}