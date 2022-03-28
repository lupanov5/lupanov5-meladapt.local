<?php
namespace dnext\Helpers;

use CModule;
use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

/**
 * Class TextHelper
 * @package dnext\helpers
 */
class HighLoadHelper
{
    private $hblocksData = [];

    private CONST REGION = 'Region';

    private CONST LINES = 'Lines';

    public function __construct()
    {
        //$tableName = "b_hlbd_manufacturer";
        $hlblocks = \Bitrix\Highloadblock\HighloadBlockTable::getList(
            array("filter" => array(
            //    'TABLE_NAME' => $tableName
            ))
        )->fetchAll();

        foreach ($hlblocks as $hlblock) {
            $this->hblocksData[$hlblock['NAME']] = [
                'ID'    => $hlblock['ID'],
                'NAME'    => $hlblock['NAME'],
                'TABLE_NAME'    => $hlblock['TABLE_NAME'],
            ];
        }
    }

    public function getHBlocks()
    {
        return $this->hblocksData;
    }

    private function getHighLoadBlock($hlBlockId)
    {
        $result = [];

        CModule::IncludeModule('iblock');
        CModule::IncludeModule('highloadblock');
        $hlblock = HL\HighloadBlockTable::getById($hlBlockId)->fetch(); // id highload блока
        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entityClass = $entity->getDataClass();
        $res = $entityClass::getList(array(
            'select' => array('*'),
            'order' => array('ID' => 'ASC'),
            'filter' => array()
        ));
        foreach ($res->fetchAll() as $item) {
            $result[$item['UF_XML_ID']] = $item;
        }

        return $result;
    }

    /**
     * Получить регионы на языке сайта
     *
     * @return array
     */
    public function getRegions()
    {
        $id = $this->hblocksData[self::REGION]['ID'];
        $regions = $this->getHighLoadBlock($id);
        $result = [];

        foreach ($regions as $key => $region) {
            $result[$key]  = $region;
            $result[$key]['NAME'] = $this->getTranslated($region);

        }

        return $result;
    }

    /**
     * Получить направления деятельности
     */
    public function getLines()
    {
        $id = $this->hblocksData[self::LINES]['ID'];

        return $this->getHighLoadBlock($id);
    }

    /**
     * Получаем массив, ключи которого - ID элементов ХЛБлока
     * и с полем NAME на текущем языке сайта
     *
     * @return array
     */
    public function getFormattedLines()
    {
        $lines = $this->getLines();
        $result = [];
        foreach ($lines as $key => $line) {
            $result[$key]  = $line;
            $result[$key]['NAME'] = $this->getTranslated($line);
        }

        return $result;
    }

    private function getTranslated(array $line)
    {
        if(LANGUAGE_ID === 'ru') {
            $lang = $line['UF_NAME'];
        } else {
            $lang = $line['UF_DESCRIPTION'];
        }

        return $lang;
    }
}