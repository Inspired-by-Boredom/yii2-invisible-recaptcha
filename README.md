<p align="center">
    <a href="https://developers.google.com/recaptcha/ " target="_blank">
        <img src="https://www.gstatic.com/images/icons/material/product/2x/recaptcha_48dp.png" height="100px">
    </a>
    <h1 align="center">Invisible reCAPTCHA</h1>
    <br>
</p>

Facade of Invisible reCAPTCHA by Google for Yii2 Framework. For more info read [official documentation](https://developers.google.com/recaptcha/).

[![Build Status](https://travis-ci.org/Vintage-web-production/yii2-invisible-recaptcha.svg?branch=master)](https://travis-ci.org/Vintage-web-production/yii2-invisible-recaptcha)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Vintage-web-production/yii2-invisible-recaptcha/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Vintage-web-production/yii2-invisible-recaptcha/?branch=master)
[![Total Downloads](https://poser.pugx.org/vintage/yii2-invisible-recaptcha/downloads)](https://packagist.org/packages/vintage/yii2-invisible-recaptcha)
[![Latest Stable Version](https://poser.pugx.org/vintage/yii2-invisible-recaptcha/v/stable)](CHANGELOG.md)
[![Latest Unstable Version](https://poser.pugx.org/vintage/yii2-invisible-recaptcha/v/unstable)](CHANGELOG.md)

Installation
------------
#### Install package
Run command
```bash
$ composer require vintage/yii2-invisible-recaptcha
```
or add
```json
"vintage/yii2-invisible-recaptcha": "~1.0"
```
to the require section of your composer.json.

Usage
-----
1. Creates API key in your [Google Account](https://www.google.com/recaptcha/admin#createsite)

2. Configure API keys in `frontend/config/params-local.php`

```php
<?php

use vintage\recaptcha\helpers\RecaptchaConfig;

return [
    RecaptchaConfig::SITE_KEY => 'your_site_key',
    RecaptchaConfig::PRIVATE_KEY => 'your_private_key',
];
```

3. Call widget in form

```html
<form id="send-feedbacl-js" method="post">
```
```php
<?= \vintage\recaptcha\widgets\InvisibleRecaptcha::widget([
    'formSelector' => '#send-feedback-js',
]) ?>
```
```html
<button type="submit">Send</button>
</form>
```

4. Validate in backend
```php
\vintage\recaptcha\validators\InvisibleRecaptchaValidator::validateInline(
    Yii::$app->getRequest()->post()
);
```

or if you want to handle the errors

```php
$validator = new \vintage\recaptcha\validators\InvisibleRecaptchaValidator(
    Yii::$app->getRequest()->post()
);
if (!$validator->validate()) {
    return $validator->getErrors();
}
```

Configuration
-------------
Widget configuration options.

| Option | Description | Type | Default |
|--------|-------------|------|---------|
| options | Html options for recaptcha container | array | `['data-badge' => 'inline', 'data-size' => 'invisible']` |
| formSelector | Html form selector | string | 'form.invisible-recaptcha-js' |
| callback | Callback JS function. Calls after captcha was successfully passed | string | 'triggerReCaptcha' |
| siteKey | API site key | string | - |

License
-------
[![License](https://poser.pugx.org/vintage/yii2-invisible-recaptcha/license)](LICENSE)

This project is released under the terms of the BSD-3-Clause [license](LICENSE).

Copyright (c) 2017, [Vintage Web Production](https://vintage.com.ua/)