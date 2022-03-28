<?php

namespace dnext\Traits;

use dnext\Exceptions\FeedbackException;
use dnext\Exceptions\IBlockNotFoundCodeException;
use dnext\Helpers\ElementsHelper;
use Exception;

/**
 * Трейт реализует необходимые методы для форм обратной связи
 * Trait Fillable
 * @package dnext\Traits
 */
trait Fillable
{
    /**
     * По наличию этого метода проверяется, подключен ли трейт в классе
     */
    public function hasTrait() {}

    /**
     * Возвращает поля формы
     * @return mixed
     */
    public function getFormFields()
    {
        return $this->formFields;
    }

    /**
     * Установка свойств из формы
     * @param $formFields
     */
    public function setFormFields($formFields)
    {
        $this->formFields = $formFields;
    }

    public function getPropertiesForStore()
    {
        $formFields = $this->getFormFields();

        $result = [];

        foreach ($formFields as $field) {
            if($field['property'] && !empty($field['store'])) {
                $result[$field['store']] = $field['value'];
            }
        }

        $additionalProperties = $this->getAdditionalProperties();

        if(!empty($additionalProperties) && is_array($additionalProperties)) {
            $result = $result + $additionalProperties;
        }

        return $result;
    }

    public function getMainFieldsForStore()
    {
        $formFields = $this->getFormFields();

        $result['IBLOCK_ID'] = $this->getId();

        foreach ($formFields as $field) {
            if(!$field['property'] && !empty($field['store'])) {
                $result[$field['store']] = $field['value'];
            }
        }

        if(empty($result['NAME'])) $result['NAME'] = $this->getElementName();

        $additionalFields = $this->getAdditionalFields();

        if(!empty($additionalFields) && is_array($additionalFields)) {
            $result = $result + $additionalFields;
        }

        return $result;
    }

    public function getElementName()
    {
        return 'Обратная связь от ' . date('d.m.Y');
    }

    public function getEventName()
    {
        if(!defined('EVENT_NAME')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Получает поля для почтового отправления и формирует
     * массив для создания почтового события
     * @param $elementId
     * @return array
     */
    public function getMailFields($elementId)
    {
        if (!$this->getEventName()) throw new FeedbackException('EVENT в модели не указан');

        $element = ElementsHelper::getElementById($elementId);
        $fileIds = [];

        if (!empty($element['FILES']['VALUE'])) {
            foreach ($element['FILES']['VALUE'] as $file) {
                $fileIds[] = $file;
            }
        }

        $fields = $this->getFieldsForMail();
        // добавим общие поля
        $fields['DATE'] = date('d.m.Y H:i');

        // Вызов события
        $result = [
            "EVENT_NAME"    => self::EVENT_NAME,
            "LID"       => SITE_ID,
            "C_FIELDS"  => $fields,
            "FILE"      => $fileIds,
        ];

        return $result;
    }

    /**
     * Дополнительные поля не из формы, для сохранения в БД
     * если есть, переопределяются в модели, например XML_ID, CODE...
     * например: return ['CODE' => 'super-code']
     * @return false
     */
    public function getAdditionalFields()
    {
        return false;
    }

    /**
     * Дополнительные свойства не из формы, для сохранения в БД
     * если есть, переопределяются в модели
     * например: return ['SECRET' => 'super-secret']
     * @return false
     */
    public function getAdditionalProperties()
    {
        return false;
    }

    public function getFieldsForMail()
    {
        $formFields = $this->getFormFields();

        return [
            'AUTHOR' => $formFields['name']['value'],
            'AUTHOR_EMAIL' => $formFields['email']['value'],
            'AUTHOR_PHONE' => !empty($formFields['phone']['value']) ? $formFields['phone']['value'] : 'не указан',
            'TEXT' => $formFields['message']['value'],
        ];
    }

    /**
     * Метод вызывается после добавления элемента в БД
     */
    public function afterAdd() {}
}