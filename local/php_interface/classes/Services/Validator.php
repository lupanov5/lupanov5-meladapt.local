<?php

namespace dnext\Services;

use dnext\Exceptions\DnextValidationException;

//use ReCaptcha\ReCaptcha;
use DateTime;
use ReCaptcha\ReCaptcha;

/**
 * Class Validation
 *
 * @package dnext
 */
class Validator
{
    protected $errorMessages = [
        'recaptcha' => [
            'ru' => 'Recaptcha не пройдена',
            'en' => 'Recaptcha not passed',
        ],
        'turing' => [
            'ru' => 'Защита от ботов не пройдена',
            'en' => 'Anti-bot pass failed',
        ],
        'unknown' => [
            'ru' => 'Ошибка в поле #FIELD#',
            'en' => 'Error in #FIELD#',
        ],
        'format' => [
            'ru' => 'Неверный формат ввода поля #FIELD#',
            'en' => 'Wrong format of #FIELD#',
        ],
        'empty' => [
            'ru' => 'Поле #FIELD# не может быть пустым.',
            'en' => 'The field #FIELD# cannot be empty.',
        ],
        'min' => [
            'ru' => 'Минимальное количество символов в поле #FIELD#: #PARAM#',
            'en' => 'The field #FIELD# cannot be shorter #PARAM# chars',
        ],
        'max' => [
            'ru' => 'Максимальное количество символов в поле #FIELD#: #PARAM#',
            'en' => 'The field #FIELD# cannot be longer #PARAM# chars',
        ],
        'inn' => [
            'ru' => 'Проверьте правильность заполнения ИНН',
            'en' => 'Check the correctness of filling in the ITIN',
        ],
    ];


    /**
     * Предустановленные паттерны PCRE, доступ по имени
     *
     * @var array $patterns
     */
    private $patterns = array(
        'phone' => '/^\+?[\d,\-,(,)]{6,18}$/',
        'email' => '/^[-a-z0-9!#$%&\'*+\/\=\?^_`{|}~]+(?:\.[-a-z0-9!#$%&\'*+\/\=\?^_`{|}~]+)*@(?:[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])?\.)+.*(?:aero|arpa|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|travel|[a-z][a-z])$/i',
        'price' => '/^[0-9]+/',
        'sale' => '/^(0{0,2}[0-9]|0?[1-9][0-9]|100)$/',
        'int' => '/^[0-9]+/',
        'text' => '/.*/',
        'name' => '/.*/',
        'array' => '/.*/',
        'date' => '/[0-9].*/',
     //   'inn' => '^[0-9]{10}$',
    );

    private $field;

    public function __construct($field)
    {
        $this->field = $field;
    }

    public function run()
    {
        if (!empty($this->field['rules'])) {
            $rules = explode('|', $this->field['rules']);

            foreach ($rules as $rule) {
                $param = '';
                $ruleParts = explode(':', $rule);
                $ruleName = $ruleParts[0];
                if (!empty($ruleParts[1])) {
                    $param = $ruleParts[1];
                }

                try {
                    switch ($ruleName) {
                        case 'turing':
                            if (!$this->turingTest()) {
                                throw new DnextValidationException($this->getErrors('turing'));
                            }
                            break;
                        case 'recaptcha':
                            if (!$this->validateRecaptcha()) {
                                throw new DnextValidationException($this->getErrors('recaptcha'));
                            }
                            break;
                        case 'required':
                            if (!$this->is_required()) {
                                throw new DnextValidationException($this->getErrors('required'));
                            }
                            break;
                        case 'email':
                            if (!$this->is_email()) {
                                throw new DnextValidationException($this->getErrors('format'));
                            }
                            break;
                        case 'phone':
                            if (!$this->is_phone()) {
                                throw new DnextValidationException($this->getErrors('format'));
                            }
                            break;
                        case 'date':
                            if (!$this->is_date($param)) {
                                throw new DnextValidationException($this->getErrors('format'));
                            }
                            break;
                        case 'min':
                            if (!$this->min($param)) {
                                throw new DnextValidationException($this->getErrors('min', $param));
                            }
                            break;
                        case 'max':
                            if (!$this->max($param)) {
                                throw new DnextValidationException($this->getErrors('max', $param));
                            }
                            break;
                        case 'inn':
                            if (!$this->is_inn($param)) {
                                throw new DnextValidationException($this->getErrors('inn', $param));
                            }
                            break;
                    }
                } catch (DnextValidationException $e) {
                    return $e->getMessage();
                }
            }
        }

        return null;
    }

    /**
     * Поле-ловушка должно быть пустым
     * @return bool
     */
    private function turingTest()
    {
        if (!isset($this->field['value'])
            || (isset($this->field['value']) && !empty($this->field['value']))) {
            return false;
        }

        return true;
    }

    /**
     * Валидация google-recaptcha
     * @return bool
     */
    private function validateRecaptcha()
    {
        $recaptcha = new ReCaptcha(RECAPTCHA_SECRET_KEY);

        $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
            ->verify($this->field['value'], $_SERVER['REMOTE_ADDR']);

        if (!$resp->isSuccess()) {
            return false;
        }

        return true;
    }

    /**
     * Поле обязательно к заполнению
     * @return bool
     */
    private function is_required()
    {
        return empty($this->field['value']) ? false : true;
    }

    private function is_email()
    {
        if (!filter_var($this->field['value'], FILTER_VALIDATE_EMAIL)) return false;

        return true;
    }

    private function is_phone()
    {
        $regex = '/^\+?[\d,\-,(,)]{6,18}$/';

        if ($this->field['value'] !== '' && preg_match($regex, $this->field['value']) !== 1) {
            return false;
        }

        return true;
    }

    private function is_inn($param)
    {

        if (!(mb_ereg_match('^[0-9]{10}$', $this->field['value']) ||
            mb_ereg_match('^[0-9]{12}$', $this->field['value']))) {
            return false;
        } else {
            return true;
        }


    }


    private function is_date($format = 'd.m.Y')
    {
        $d = DateTime::createFromFormat($format, $this->field['value']);
        return $d && $d->format($format) == $this->field['value'];
    }

    /**
     * Минимальная длина строки в поле
     * @param int $param
     * @return bool
     */
    private function min($param = 1)
    {
        if ($this->field['value'] !== '' && mb_strlen($this->field['value'], 'utf-8') < $param) {
            return false;
        }

        return true;
    }

    /**
     * Максимальная длина строки в поле
     * @param int $param
     * @return bool
     */
    private function max($param = 1)
    {
        if ($this->field['value'] !== '' && mb_strlen($this->field['value'], 'utf-8') > $param) {
            return false;
        }

        return true;
    }

    private function getErrors($code, $param = '')
    {
        switch ($code) {
            case 'turing':
                $message = $this->errorMessages['turing'][LANGUAGE_ID];
                break;
            case 'recaptcha':
                $message = $this->errorMessages['recaptcha'][LANGUAGE_ID];
                break;
            case 'required':
                $message = $this->errorMessages['empty'][LANGUAGE_ID];
                break;
            case 'format':
                $message = $this->errorMessages['format'][LANGUAGE_ID];
                break;
            case 'min':
                $message = $this->errorMessages['min'][LANGUAGE_ID];
                break;
            case 'inn':
                $message = $this->errorMessages['inn'][LANGUAGE_ID];
                break;
            default:
                $message = 'Другая ошибка';
        }

        $result = str_replace('#FIELD#', $this->field[LANGUAGE_ID], $message);
        $result = str_replace('#PARAM#', $param, $result);

        return $result;
    }
}
