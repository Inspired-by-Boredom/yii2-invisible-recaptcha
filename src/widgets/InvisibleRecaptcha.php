<?php
/**
 * @link https://github.com/Vintage-web-production/yii2-i18n
 * @copyright Copyright (c) 2017 Vintage Web Production
 * @license BSD 3-Clause License
 */

namespace vintage\recaptcha\widgets;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use vintage\recaptcha\helpers\RecaptchaConfig;

/**
 * Renders Invisible reCAPTCHA.
 *
 * @property array options
 * @property string $formSelector
 * @property string $callback
 * @property string $siteKey
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class InvisibleRecaptcha extends Widget
{
    const CALLBACK_DEFAULT = 'triggerReCaptcha';
    const API_SCRIPT_URL = 'https://www.google.com/recaptcha/api.js';

    /**
     * @var array
     */
    private $_options = ['data-badge' => 'inline', 'data-size' => 'invisible'];
    /**
     * @var string
     */
    private $_formSelector = 'form.invisible-recaptcha-js';
    /**
     * @var string
     */
    private $_callback = self::CALLBACK_DEFAULT;
    /**
     * @var string
     */
    private $_siteKey;
    /**
     * @var string
     */
    private static $_widgetID = 0;


    /**
     * Setter for options.
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->_options = $options;
    }

    /**
     * Setter for form selector.
     *
     * @param string $formSelector
     */
    public function setFormSelector($formSelector)
    {
        $this->_formSelector = $formSelector;
    }

    /**
     * Setter for callback.
     *
     * @param string $callback
     */
    public function setCallback($callback)
    {
        $this->_callback = $callback;
    }

    /**
     * Setter for site key.
     *
     * @param string $siteKey
     */
    public function setSiteKey($siteKey)
    {
        $this->_siteKey = $siteKey;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->_siteKey)) {
            $globalKey = RecaptchaConfig::getSiteKey();
            if ($globalKey === null) {
                throw new InvalidConfigException('You should to set site key');
            }
            $this->_siteKey = $globalKey;
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerJs();
        return Html::tag('div', '', ArrayHelper::merge($this->_options, [
            'class' => 'g-recaptcha g-recaptcha-' . self::$_widgetID,
            'data-sitekey' => $this->_siteKey,
            'data-callback' => $this->_callback,
        ]));
    }

    /**
     * Register JS files to view.
     */
    protected function registerJs()
    {
        $view = $this->getView();
        $view->registerJsFile(self::API_SCRIPT_URL, [
            'position' => View::POS_HEAD,
            'async' => true,
            'defer' => true,
        ]);
        $view->registerJs(
            "$('$this->_formSelector')"
            . '.on(\'afterValidate\',function(){grecaptcha.execute('
            . self::$_widgetID++
            . ');});',
            View::POS_END
        );
    }
}
