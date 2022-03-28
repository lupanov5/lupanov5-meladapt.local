<?php

namespace dnext\Base;

use Bitrix\Main\Data\Cache;
use CIBlockResult;
use CIBlockElement;
use Bitrix\Iblock\IblockTable;
use dnext\exceptions\ApplicationException;
use dnext\exceptions\IBlockNotFoundCodeException;
use dnext\Helpers\ApplicationHelper;


class Iblock
{
    /**
     * Если эта переменная заполнена в наследниках, то применяется мультияз!
     * @var string
     */
    protected static $iblockCode = '';

    protected static $baseCode = '';

    /**
     * @var string
     */
    private $url = '';

    /**
     * @var array
     */
    private $where = [];

    /**
     * @var array
     */
    private $limits = [];

    /**
     * @var array
     */
    private $select = [];

    /**
     * @var array
     */
    private $orderBy = [];

    /**
     * @var array
     */
    protected $filter = [];

    protected $fields = ['ID', 'CODE', 'IBLOCK_ID', 'NAME', 'PREVIEW_TEXT', 'SECTION_CODE', 'SORT'];

    public function select(?array $fields = []): self
    {
        $this->select = $fields;

        return $this;
    }

    public function where(?array $fields = []): self
    {
        $this->where = $fields;

        return $this;
    }

    public function orderBy(?array $fields = []): self
    {
        $this->orderBy = $fields;

        return $this;
    }

    public function setLimits(?array $fields = []): self
    {
        $this->limits = $fields;

        return $this;
    }

    public function setUrl(string $template): self
    {
        $this->url = $template;

        return $this;
    }

    /**
     * @return CIBlockResult|int
     */
    protected function getQuery()
    {
        $query = CIBlockElement::GetList(
            $this->orderBy,
            $this->where,
            false,
            $this->limits,
            $this->select
        );

        if ($this->url) {
            $query->SetUrlTemplates($this->url);
        }

        return $query;
    }

    public function all(): array
    {
        $query = $this->getQuery();

        $elements = [];
        while ($el = $query->GetNextElement()) {
            $el = $el->GetFields();
            $elements[$el['ID']] = $el;
        }

        return $elements;
    }

    public function allFieldsAndProps(): array
    {
        $query = $this->getQuery();

        $elements = [];
        while ($el = $query->GetNextElement()) {
            $el = $el->GetFields()+$el->GetProperties();
            $elements[$el['ID']] = $el;
        }

        return $elements;
    }

    public function allWithProps($active = "Y", $filter = []): array
    {
        ApplicationHelper::includeModules(['iblock']);

        $defaultFilter = [
            'IBLOCK_ID' => $this->getIdByLanguage(),
            "ACTIVE" => $active,
        ];

        if(!empty($filter) and is_array($filter)) {
            $defaultFilter += $filter;
        }

        $this->where($defaultFilter);
        $query = $this->getQuery();

        $elements = [];
        while ($el = $query->GetNextElement()) {
            $el = $el->GetFields()+$el->GetProperties();

            $elements[$el['ID']] = $el;
        }

        return $elements;
    }

    /**
     * @return array
     */
    public function first(): ?array
    {
        $query = $this->getQuery();
        if (!$query) {
            return null;
        }

        $element = $query->GetNextElement();
        if (!$element) {
            return null;
        }

        return $element->GetFields()+$element->GetProperties();
    }

    /**
     * @param int $iblockId
     * @param int $elId
     * @param string $code
     * @return array
     */
    public function getMultiplePropValues(int $iblockId, int $elId, string $code): array
    {
        $query = CIBlockElement::GetProperty($iblockId, $elId, [], ['CODE' => $code]);
        $elements = [];
        while ($el = $query->Fetch()) {
            $elements[] = $el;
        }

        return $elements;
    }

    public function getIblockId()
    {
        ApplicationHelper::includeModules(['iblock']);

        $this->setLanguagePrefix();

        if (!static::$iblockCode) {
            throw new IBlockNotFoundCodeException();
        }

        return IblockTable::query()->setSelect(['ID'])->where('CODE', static::$iblockCode)->fetchObject()->getId();
    }

    public function getId()
    {
        $result = false;

        if(NX_CACHE_ENABLED) {

            $hash = md5(serialize(static::$iblockCode));
            $cache = Cache::createInstance(); // получаем экземпляр класса
            $cacheCode = NX_CACHE_CODE . '_getId_' . $hash;

            if ($cache->initCache(NX_CACHE_LONG, $cacheCode)) {
                $result = $cache->getVars()[$cacheCode];
            } elseif ($cache->startDataCache()) {
                $result = $this->getIblockId();
                $cache->endDataCache([$cacheCode => $result]); // записываем в кеш
            }


        } else {
            $result = $this->getIblockId();
        }

        return $result;
    }

    public function getIdByCode($iBlockCode)
    {
        ApplicationHelper::includeModules(['iblock']);

        if (!$iBlockCode) {
            throw new IBlockNotFoundCodeException();
        }

        return IblockTable::query()->setSelect(['ID'])->where('CODE', $iBlockCode)->fetchObject()->getId();
    }

    /**
     * Если установлена константа BASE_CODE,
     * значит есть две языковых версии модели
     * с префиксами _en, _ru
     */
    private function setLanguagePrefix()
    {
        if(defined('static::BASE_CODE')) {
            if(LANGUAGE_ID !== 'ru') {
                static::$iblockCode = static::BASE_CODE . '_en';
            } else {
                static::$iblockCode = static::BASE_CODE . '_ru';
            }
        }
    }

    /**
     * Получение id инфоблока с учетом языкового префикса
     * например: для news_ru и news_en в модели должна быть константа BASE_CODE='news'
     *
     * @return mixed
     */
    public function getIdByLanguage()
    {
        $this->setLanguagePrefix();

        return $this->getId();
    }

    /**
     * Получить все элементы с полями $fields
     *
     * @param string[] $fields
     * @return array
     * @throws \Exception
     */
    public function getAll(): array
    {
        return static::instance()
            ->select(['ID', 'CODE', 'IBLOCK_ID', 'NAME', 'PREVIEW_TEXT', 'ACTIVE_FROM', 'ACTIVE_TO'])
            ->where(['IBLOCK_ID' => static::instance()->getId(), 'ACTIVE' => 'Y'])
            ->orderBy(['sort' => 'asc'])
            ->all();
    }

    public function getTotal(): int
    {
        if(!empty($this->getAll())) {
            return count($this->getAll());
        }
        return 0;
    }

    public function getAllFiltered()
    {
        $this->filter['IBLOCK_ID'] = static::instance()->getId();
        $this->filter['ACTIVE'] = 'Y';

        return static::instance()
            ->select($this->fields)
            ->where($this->filter)
            ->orderBy(['sort' => 'asc'])
            ->setLimits()
            ->all();
    }

    public function getAllByFilter($filter): array
    {
        ApplicationHelper::includeModules(['iblock']);
        $filter['IBLOCK_ID'] = $this->getIdByLanguage();
        $this->where([
            $filter,
        ]);
        $query = $this->getQuery();

        $elements = [];
        while ($el = $query->GetNextElement()) {
            $el = $el->GetFields()+$el->GetProperties();

            $elements[$el['ID']] = $el;
        }

        return $elements;
    }

    protected function setFilter($filter)
    {
        $this->filter = ['IBLOCK_ID' => $this->getIdByLanguage()] + $filter;
        return $this;
    }

    protected function setFields($fields)
    {
        $this->fields = array_merge($this->fields, $fields);
        return $this;
    }

    protected function getElement($id)
    {
        \CModule::IncludeModule("iblock");

        $element = [];

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
