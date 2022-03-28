<?php


namespace dnext\Services;

/**
 * Отправляет в CRM B24
 * Class CRMService
 * @package dnext\Services
 */
class CRMService
{

    /**
     * Что-то вроде https://zzz.bitrix24.ru/rest/2/zzz/crm.lead.add.json
     */
    private const API_URL = '';

    /**
     * Статус Лида (обычно 2 - новый)
     */
    private const STATUS_ID = 2;

    /**
     * ID источника
     */
    private const SOURCE_ID = 'WEB';

    /**
     * При true отправка в CRM не происходит
     */
    private const TEST = true;

    private $form = [];

    private $fields = [
            ['name', 'required'],
            ['phone', 'required'],
            ['email', 'required'],
            ['message', 'required'],
            ['company', 'required'],
        ];

    public function __construct(array $data)
    {
        try {
            $this->setData($data);

            $this->send();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @param array $data
     * @param string $title
     */
    protected function setData(array $data)
    {



        $this->form['fields'] = [
            'TITLE' => $data['company'],
            'STATUS_ID' => self::STATUS_ID,
            'SOURCE_ID' => self::SOURCE_ID,
            'NAME'  => $data['name'],
            'PHONE' => [
                '59381' => [ //n0
                    "VALUE" => $data['phone'] ?? '',
                    "VALUE_TYPE" => "MOBILE",
                ],
            ],
            'EMAIL' => [
                'n0' => [ //n0
                    'VALUE' => $data['email'] ?? '',
                    'VALUE_TYPE' => 'WORK',
                ]
            ],
            'COMPANY_TITLE' => $data['company'] ?? '',
            'COMMENTS' => $data['message'] ?? '',
            'UF_CRM_1584959167' => $data['CRM_CODE'] ?? '',
        ];
    }

    /**
     * @return mixed
     */
    public function getData(): array
    {
        return $this->form;
    }

    /**
     * Возвращает URL API B24
     * @return string
     */
    protected function getAPIUrl()
    {
        return self::API_URL;
    }

    /**
     * Отправка формы
     * @throws \Exception
     */
    public function send()
    {

        $data = $this->getData();

        if(self::TEST) {
            dd($data);
        }

        $apiUrl = $this->getAPIUrl();

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $apiUrl,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ));

        $result = curl_exec($curl);
        $result = json_decode($result, 1);
        $err = curl_error($curl);

        if ($err !== '') {
            throw new \Exception('Ошибка соединения' . $err);
        };
        curl_close($curl);

        if (array_key_exists('error', $result)) {
            throw new \Exception("Ошибка при сохранении лида: " . $result['error_description']);
        }
    }
}