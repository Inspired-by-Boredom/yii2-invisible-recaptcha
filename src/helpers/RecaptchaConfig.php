<?php
/**
 * @link https://github.com/Vintage-web-production/yii2-i18n
 * @copyright Copyright (c) 2017 Vintage Web Production
 * @license BSD 3-Clause License
 */

namespace vintage\recaptcha\helpers;

use Yii;

/**
 * Helpers for recaptcha config.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class RecaptchaConfig
{
    const SITE_KEY      = 'recaptcha-site-key';
    const PRIVATE_KEY   = 'recaptcha-private-key';

    /**
     * Returns site key.
     *
     * @return null|string
     */
    public static function getSiteKey()
    {
        return !empty(Yii::$app->params[self::SITE_KEY])
            ? Yii::$app->params[self::SITE_KEY]
            : null;
    }

    /**
     * Returns private key.
     *
     * @return null|string
     */
    public static function getPrivateKey()
    {
        return !empty(Yii::$app->params[self::PRIVATE_KEY])
            ? Yii::$app->params[self::PRIVATE_KEY]
            : null;
    }
}
