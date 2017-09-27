<?php
/**
 * @link https://github.com/Vintage-web-production/yii2-i18n
 * @copyright Copyright (c) 2017 Vintage Web Production
 * @license BSD 3-Clause License
 */

namespace vintage\recaptcha\tests\unit\widgets;

use vintage\recaptcha\helpers\RecaptchaConfig;
use Yii;
use vintage\recaptcha\widgets\InvisibleRecaptcha;

/**
 * Test case for InvisibleRecaptcha widget.
 * 
 * @var \UnitTester $tester
 * 
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class InvisibleRecaptchaTest extends \Codeception\Test\Unit
{
    /**
     * @expectedException \yii\base\InvalidConfigException
     */
    public function testInit()
    {
        unset(Yii::$app->params[RecaptchaConfig::SITE_KEY]);
        new InvisibleRecaptcha();
    }

    public function testRun()
    {
        $expectedHTML = (new InvisibleRecaptcha())->run();
        $actualHTML =
            '<div class="g-recaptcha g-recaptcha-1" '
                . 'data-badge="inline" '
                . 'data-size="invisible" '
                . 'data-sitekey="' . Yii::$app->params[RecaptchaConfig::SITE_KEY] . '" '
                . 'data-callback="' . InvisibleRecaptcha::CALLBACK_DEFAULT . '">'
            . '</div>';

        $this->assertEquals($expectedHTML, $actualHTML);
    }

    public function testApiEndpoint()
    {
        $this->assertEquals('https://www.google.com/recaptcha/api.js', InvisibleRecaptcha::API_SCRIPT_URL);
    }
}
