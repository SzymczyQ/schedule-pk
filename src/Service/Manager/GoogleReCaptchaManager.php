<?php

namespace App\Service\Manager;

/**
 * Class GoogleReCaptchaManager
 * @package App\Service\Manager
 */
final class GoogleReCaptchaManager
{
    /**
     * @var string const RE_CAPTCHA_URL
     */
    private const RE_CAPTCHA_URL = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * @param null|string $responseToken
     * @return bool
     */
    public static function isValid(?string $responseToken): bool
    {
        $reCaptchaResponse = file_get_contents(
            self::RE_CAPTCHA_URL
            . '?secret='
            . getenv('GOOGLE_RECAPTCHA_SECRET_KEY')
            . '&response='
            . $responseToken
        );
        $reCaptcha = json_decode($reCaptchaResponse);

        if (isset($reCaptcha->success) && $reCaptcha->success) {
            return $reCaptcha->score >= 0.5;
        }

        return false;
    }
}