<?php


namespace dnext\Helpers;

use dnext\Traits\EventLog;


class ReCaptchaHelper
{
    use EventLog;
    
    
    /**
     * @var string URL сервиса для проверка робота
     */
    protected $url;
    
    /**
     * @var string секретный ключ
     */
    protected $secret;
    
    /**
     * @var string токен пользователя
     */
    protected $token;
    
    /**
     * ReCaptcha constructor.
     *
     * @param $token
     */
    public function __construct($token)
    {
        $this->url = RECAPTCHA_URL;
        $this->secret = RECAPTCHA_SECRET_KEY;
        $this->token = $token;
    }
    
    /**
     * Проверка при помощи рекаптчи
     *
     * @return bool
     */
    public function isValidRecaptcha(): bool
    {
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            [
                'secret' => $this->secret,
                'response' => $this->token,
            ]
        );
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
        
        if ($response && $response['success'] && $response['score'] >= 0.5) {
            self::debug($response);
            return true;
        }
        self::error($response);
        return false;
    }
}
