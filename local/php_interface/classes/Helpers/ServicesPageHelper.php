<?php

namespace dnext\Helpers;

use Bitrix\Main\Context;

/**
 * Class ServicesPageHelper
 * @package dnext\helpers
 */
class ServicesPageHelper
{
    private const GET_PARAM_NAME = 'page-tab';
    private const DEFAULT_TYPE_DETAIL_PAGE = 'description';

    public static function getTypeDetailPage(): string
    {
        $currentType = (string) (Context::getCurrent()->getRequest()->get(self::GET_PARAM_NAME) ?: self::DEFAULT_TYPE_DETAIL_PAGE);
        $allowedTypes = ['articles', self::DEFAULT_TYPE_DETAIL_PAGE, 'doctors', 'prices', 'reviews'];

        return in_array($currentType, $allowedTypes) ? $currentType : self::DEFAULT_TYPE_DETAIL_PAGE;
    }
}
