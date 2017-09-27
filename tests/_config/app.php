<?php

use vintage\recaptcha\helpers\RecaptchaConfig;

return [
    'id' => 'test-app',
    'class' => 'yii\console\Application',

    'basePath' => Yii::getAlias('@tests'),
    'vendorPath' => Yii::getAlias('@vendor'),
    'runtimePath' => Yii::getAlias('@tests/_output'),

    'bootstrap' => [],

    'params' => [
        RecaptchaConfig::SITE_KEY => 'global-site-key',
        RecaptchaConfig::PRIVATE_KEY => 'private-key',
    ],
];