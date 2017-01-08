<?php

namespace CoreBundle\Util;

class PasswordUtil
{
    private static $options = [
        'cost' => 4,
        'salt' => '5=q@476usj-#@1yQjSH496pcT5CEbzjD'
    ];

    public static function encrypt(String $password)
    {
        ValidateUtil::notNull($password);
        ValidateUtil::notEmpty($password);
        return password_hash($password, PASSWORD_BCRYPT, PasswordUtil::$options);
    }
}