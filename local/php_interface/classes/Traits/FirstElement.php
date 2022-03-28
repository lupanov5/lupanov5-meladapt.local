<?php

namespace dnext\Traits;

use Exception;
use CIBlockElement;

trait FirstElement
{
    /**
     * Получение первого элемента
     *
     * @return array
     * @throws Exception
     */
    public function firstEl(): array
    {
        \CModule::IncludeModule("iblock");

        return CIBlockElement::GetList(
            [],
            ['IBLOCK_ID' => self::instance()->getId()],
            false,
            false,
            [
                "ID"
            ]
        )->Fetch() ?: [];
    }

    /**
     * Получение идентификатора первого элемента
     *
     * @return int
     */
    public function firstElId(): int
    {
        \CModule::IncludeModule("iblock");

        $element = CIBlockElement::GetList(
            [],
            ['IBLOCK_ID' => self::instance()->getId()],
            false,
            false,
            [
                "ID"
            ]
        )->Fetch() ?: [];

        return (int)$element['ID'];
    }

    /**
     * Получение идентификатора первого элемента
     * @param $iBlockId
     * @return int
     */
    public function firstElementIdByIblock($iBlockId)
    {
        $element = \CIBlockElement::GetList(
            [],
            ['IBLOCK_ID' => (int)$iBlockId],
            false,
            false,
            [
                "ID"
            ]
        )->Fetch() ?: [];

        return (int)$element['ID'];
    }

    /**
     * Получаем первую запись со всеми полями и свойствами
     *
     * @return array|int
     */
    public function getFirstElement()
    {
        \CModule::IncludeModule("iblock");

        $element = 0;
        $id = $this->firstElId();
        if(!empty($id)) {
            $res = CIBlockElement::GetByID($id);
            if($ar_res = $res->GetNextElement()) {
                //$element = $ar_res;
                $element = $ar_res->GetFields()+$ar_res->GetProperties();
            }
        }

        return $element;
    }
}