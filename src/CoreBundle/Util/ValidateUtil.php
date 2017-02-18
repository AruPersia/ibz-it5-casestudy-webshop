<?php

namespace CoreBundle\Util;

class ValidateUtil
{

    public static function notNulls(...$objects)
    {
        foreach ($objects as $object) {
            self::notNull($object);
        }
    }

    public static function notNull($object, $message = 'Validated object is null!')
    {
        if (is_null($object)) {
            throw new \InvalidArgumentException($message);
        }

        return $object;
    }

    public static function notEmpty($object, $message = 'Validated object is empty!')
    {
        if (empty($object)) {
            throw new \InvalidArgumentException($message);
        }
    }

}