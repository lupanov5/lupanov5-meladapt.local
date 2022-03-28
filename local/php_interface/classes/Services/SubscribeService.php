<?php
namespace dnext\Services;


use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use CSubscription;
use dnext\Validator;


class SubscribeService
{
    public const EVENT_NAME = 'NEWS';

    public const SEND_CONFIRM = 'N';

    private $fields = [
//        'recaptchaResponse' => [
//            'ru' => 'recaptcha',
//            'en' => 'recaptcha',
//            'rules'  => 'recaptcha|required',
//            'type'      => '',
//            'value'     => ''
//        ],
        'turing' => [
            'ru' => 'Ловушка для бота',
            'en' => 'Trap for bot',
            'rules' => 'turing',
            'type' => 'должно быть пустым',
            'value' => ''
        ],
        'email' => [
            'ru' => 'Email',
            'en' => 'Email',
            'rules' => 'required|email',
            'type' => 'email',
            'value' => ''
        ],
    ];

    private $errors = [];

    public function __construct()
    {
        Loader::includeModule('iblock');
        Loader::IncludeModule('subscribe');
    }

    public function run()
    {
        $this->prepare();

        if(empty($this->errors)) {
            $this->add();
        }

        return $this->errors;
    }

    private function prepare()
    {
        $request = Context::getCurrent()->getRequest();

        foreach ($this->fields as $name => $field) {
            $this->fields[$name]['value']  = $request->get($name);
            $this->validate($name);
        }
    }

    public function validate($name)
    {
        $validator = new Validator($this->fields[$name]);
        $result = $validator->run();
        if(!empty($result)) {
            $this->errors[$name] = $result;
        }
    }

    public function add()
    {
        $arFields = Array(
            "USER_ID" => false,
            "FORMAT" => "html",
            "SEND_CONFIRM" => self::SEND_CONFIRM,
            "EMAIL" => $this->fields['email']['value'],
            "RUB_ID" => $this->getRubId(),
            "ACTIVE" => "Y",
        );

        $subscription = new CSubscription;

        if(empty($subscription->Add($arFields, SITE_ID))) $this->setError();
    }

    /**
     * Получение рубирики подписки
     * @return int[]
     */
    private function getRubId()
    {
        return [SUBSCRIBE_NEWS_ID];
    }

    public function setError()
    {
        if(LANGUAGE_ID == 'ru') {
            $this->errors['email'] = 'Этот Email уже подписан на рассылку';
        } else {
            $this->errors['email'] = 'The address is already subscribed to the newsletter';
        }
    }
}