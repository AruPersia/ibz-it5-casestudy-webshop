<?php

namespace AppBundle\Util;

class ValidateUtil
{

    public static function notNull($obj, $message = 'Validated object is null!')
    {
        if (is_null($obj)) {
            throw new \InvalidArgumentException($message);
        }
    }

    public static function notEmpty($obj, $message = 'Validated object is empty!')
    {
        if (empty($obj)) {
            throw new \InvalidArgumentException($message);
        }
    }

}