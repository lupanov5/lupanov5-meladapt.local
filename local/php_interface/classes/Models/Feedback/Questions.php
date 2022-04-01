<?php


namespace dnext\Models\Feedback;


use dnext\Base\Iblock;
use dnext\Traits\Fillable;
use dnext\Traits\FirstElement;
use dnext\Traits\IblockIdConstant;
use dnext\Traits\MethodCacheable;
use dnext\Traits\Singleton;

class Questions extends Iblock
{
    use IblockIdConstant, Fillable;

    public $modelConstant = 'FEEDBACK_QUESTIONS_IBLOCK_ID';

    const EVENT_NAME = 'QUESTION_FORM';

    private $formFields = [
        'name' => [
            'ru' => 'Имя',
            'en' => 'Name',
            'rules' => 'required|min:2',
            'type' => '',
            'value' => '',
            'property' => false,
            'store' => 'NAME'
        ],
        'email' => [
            'ru' => 'Email',
            'en' => 'Email',
            'rules' => 'required|email',
            'type' => 'email',
            'value' => '',
            'property' => true,
            'store' => 'EMAIL'
        ],
        'comment' => [
            'ru' => 'Комментарий',
            'en' => 'Comment',
            'rules' => 'required',
            'type' => '',
            'value' => '',
            'property' => false,
            'store' => 'PREVIEW_TEXT'
        ],
//        'g-recaptcha-response' => [
//            'ru' => 'recaptcha',
//            'en' => 'recaptcha',
//            'rules' => 'recaptcha|required',
//            'type' => '',
//            'value' => ''
//        ],
    ];

    public function getFieldsForMail()
    {
        $formFields = $this->getFormFields();

        return [
            'NAME' => $formFields['name']['value'],
            'EMAIL' => $formFields['email']['value'],
            'TEXT' => $formFields['comment']['value'],
        ];
    }

    public function getAdditionalFields()
    {
        return [
            'NAME' => 'Обратная связь' . ' от ' . date('d m Y'),
            'CODE' => uniqid() . '-' . date('Y-m-d')
        ];
    }
}