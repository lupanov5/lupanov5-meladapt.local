<?php

namespace dnext\Helpers;

/**
 * Class TextHelper
 * @package dnext\helpers
 */
class TextHelper
{
    /**
     * @param $num
     * @return string
     */
    public static function numToString($num): string
    {
        $nul = 'ноль';
        $ten = [
            ['', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
            ['', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
        ];

        $a20 = ['десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать'];
        $tens = [2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто'];
        $hundred = ['', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот'];
        $unit = [ // Units
            ['копейка', 'копейки', 'копеек', 1],
            ['рубль', 'рубля', 'рублей', 0],
            ['тысяча', 'тысячи', 'тысяч', 1],
            ['миллион', 'миллиона', 'миллионов', 0],
            ['миллиард', 'милиарда', 'миллиардов', 0],
        ];
        //
        list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
        $out = [];

        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) {
                if (!intval($v)) {
                    continue;
                }

                $uk = sizeof($unit) - $uk - 1; // unit key
                $gender = $unit[$uk][3];

                list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx

                if ($i2 > 1) {
                    $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; # 20-99
                } else {
                    $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                }
                // units without rub & kop
                if ($uk > 1) {
                    $out[] = self::morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
                }
            }
        } else {
            $out[] = $nul;
        }

        $out[] = self::morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
        $out[] = $kop . ' ' . self::morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop

        return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
    }

    /**
     * Склонение словоформы
     *
     * @param $n
     * @param $f1
     * @param $f2
     * @param $f5
     * @return mixed
     */
    private static function morph($n, $f1, $f2, $f5)
    {
        $n = abs(intval($n)) % 100;

        if ($n > 10 && $n < 20) {
            return $f5;
        }

        $n = $n % 10;

        if ($n > 1 && $n < 5) {
            return $f2;
        }

        if ($n == 1) {
            return $f1;
        }

        return $f5;
    }

    /**
     * Получить числительное вместе с существительным с верным склонением
     *
     * @param $num
     * @param string[] $words
     * @return string
     */
    public static function getWordForNum(int $num, array $words = ['товар', 'товара', 'товаров']): string
    {
        return $num . ' ' . self::wordAfterNum($num, $words);
    }

    /**
     * Получить существительное во множественном числе
     *
     * @param $num
     * @param string[] $words
     * @return string
     */
    public static function getPlural(int $num, array $words = ['товар', 'товара', 'товаров']): string
    {
        return self::wordAfterNum($num, $words);
    }

    /**
     * Получить существительное по переданному числительному
     *
     * @param $num
     * @param string[] $words
     * @return string
     */
    private static function wordAfterNum(int $num, array $words = ['товар', 'товара', 'товаров']): string
    {
        $num = $num % 100;
        if ($num > 19) {
            $num = $num % 10;
        }

        switch ($num) {
            case 1:{
                return ($words[0]);
            }
            case 2:case 3:case 4:{
                return ($words[1]);
            }
            default:{
                return ($words[2]);
            }
        }
    }

    /**
     * Транслитерация кирилической строки
     *
     * @param $str
     * @return string
     */
    public static function translit(string $str): string
    {
        $tr = [
            "А" => "a", "Б" => "b", "В" => "v", "Г" => "g",
            "Д" => "d", "Е" => "e", "Ж" => "j", "З" => "z", "И" => "i",
            "Й" => "y", "К" => "k", "Л" => "l", "М" => "m", "Н" => "n",
            "О" => "o", "П" => "p", "Р" => "r", "С" => "s", "Т" => "t",
            "У" => "u", "Ф" => "f", "Х" => "h", "Ц" => "ts", "Ч" => "ch",
            "Ш" => "sh", "Щ" => "sch", "Ъ" => "", "Ы" => "yi", "Ь" => "",
            "Э" => "e", "Ю" => "yu", "Я" => "ya", "а" => "a", "б" => "b",
            "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ж" => "j",
            "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
            "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "y",
            "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya",
            " " => "-", "." => "", "/" => "-", "'" => "", "\"" => "", "«" => "", "»" => "",
        ];

        return strtr($str, $tr);
    }

    public static function cutString($string, $length)
    {
        return mb_substr($string, 0, $length, 'UTF-8');
    }
}