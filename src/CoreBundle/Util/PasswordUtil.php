<?php

namespace CoreBundle\Util;

final class PasswordUtil
{

    private static $options = [
        'cost' => 4
    ];

    public static function encrypt(String $password)
    {
        ValidateUtil::notNull($password);
        ValidateUtil::notEmpty($password);
        return password_hash($password, PASSWORD_BCRYPT, self::$options);
    }

    public static function verify(String $password, String $hash)
    {
        if (!password_verify($password, $hash)) {
            throw new PasswordHashDoesNotMatchException('Password hash does not match');
        }
    }

}