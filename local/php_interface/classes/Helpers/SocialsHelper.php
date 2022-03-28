<?php

namespace dnext\Helpers;

/**
 * Class SocialsHelper - хелпер для работы с соцсетями
 * @package dnext\helpers
 */
class SocialsHelper
{
    public static function getSocialNetworks()
    {
        return [
            'fb'    => [
                'title' => 'Facebook',
                'svg'   => '<svg class="socials__icon"><use xlink:href="#icon-fb"></use></svg>',

            ],
            'vk'    => [
                'title' => 'vk',
                'svg'   => '<svg class="socials__icon"><use xlink:href="#icon-vk"></use></svg>',

            ],
            'inst'    => [
                'title' => 'Instagram',
                'svg'   => '<svg class="socials__icon"><use xlink:href="#icon-inst"></use></svg>',
            ],
            'yt'    => [
                'title' => 'Youtube',
                'svg'   => '<svg class="socials__icon"><use xlink:href="#icon-yt"></use></svg>',
            ],
            'ok'    => [
                 'title' => 'Ok',
                 'svg'   => '<svg class="socials__icon"><use xlink:href="#icon-ok"></use></svg>',
                        ],
            'tg'    => [
                 'title' => 'Telegram',
                 'svg'   => '<svg class="socials__icon"><use xlink:href="#icon-tg"></use></svg>',
            ],

        ];
    }

    /**
     * Возвращает данные социальной сети по ее коду
     * @param $key
     * @param $type
     * @return string|null
     */
    public static function getSocial($key, $type = 'svg')
    {
        $socials = self::getSocialNetworks();

        if(key_exists($key, $socials)) {
            return $socials[$key][$type];
        }

        return null;
    }
}
