<?php
/**
 * @link https://github.com/Vintage-web-production/yii2-i18n
 * @copyright Copyright (c) 2017 Vintage Web Production
 * @license BSD 3-Clause License
 */

namespace vintage\recaptcha\validators;

use vintage\recaptcha\helpers\RecaptchaConfig;
use yii\base\InvalidConfigException;
use yii\base\Object;
use yii\httpclient\Client;

/**
 * Validator for Invisible reCAPTCHA.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class InvisibleRecaptchaValidator extends Object
{
    const RECAPTCHA_RESPONSE_PARAM = 'g-recaptcha-response';
    const VERIFY_API_ENDPOINT = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * @var string
     */
    private $_response;
    /**
     * @var null|string
     */
    private $_userIp;
    /**
     * @var string
     */
    private $_secretKey;
    /**
     * @var array
     */
    protected $errors = [];


    /**
     * @inheritdoc
     * @param array $requestData
     */
    public function __construct($requestData, $userIp = null, $config = [])
    {
        if (!empty($requestData[self::RECAPTCHA_RESPONSE_PARAM])) {
            $this->_response = $requestData[self::RECAPTCHA_RESPONSE_PARAM];
        }
        $this->_userIp = $userIp;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->_secretKey = RecaptchaConfig::getPrivateKey();
        if (empty($this->_secretKey)) {
            throw new InvalidConfigException('You should to set a private key');
        }
        if (empty($this->_response)) {
            throw new InvalidConfigException('Response is empty');
        }
    }

    /**
     * Validate inline without info about errors.
     *
     * @param array $requestData
     * @param null|string $userIp
     * @return bool
     */
    public static function validateInline($requestData, $userIp = null)
    {
        return (new self($requestData, $userIp))->validate();
    }

    /**
     * Validate request.
     *
     * @return bool
     */
    public function validate()
    {
        $this->sendRequest();
        return empty($this->getErrors());
    }

    /**
     * Returns data for request.
     *
     * @return array
     */
    private function getRequestData()
    {
        $request = [
            'secret' => $this->_secretKey,
            'response' => $this->_response,
        ];
        if (!empty($this->_userIp)) {
            $request['userIp'] = $this->_userIp;
        }

        return $request;
    }

    /**
     * Send request for verify captcha.
     *
     * @return void
     */
    protected function sendRequest()
    {
        $client = new Client();
        /* @var \yii\httpclient\Response $response */
        $response = $client->createRequest()
            ->setMethod('post')
            ->setUrl(self::VERIFY_API_ENDPOINT)
            ->setData($this->getRequestData())
            ->send();

        if ($response->getIsOk()) {
            if ($response->data['success'] == false) {
                $this->errors = $response->data['error-codes'];
            }
        } else {
            $this->errors[] = 'Http client error';
        }
    }

    /**
     * Returns errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
