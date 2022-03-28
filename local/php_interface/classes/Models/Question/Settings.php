<?php


namespace dnext\Models\Question;


use dnext\Base\Iblock;
use dnext\Traits\FirstElement;
use dnext\Traits\IblockIdConstant;
use dnext\Traits\MethodCacheable;
use dnext\Traits\Singleton;

class Settings extends Iblock
{
    use Singleton, MethodCacheable, IblockIdConstant, FirstElement;

    public $modelConstant = 'QUESTION_SETTINGS_IBLOCK_ID';

}