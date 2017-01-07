<?php

namespace AppBundle\Form\Transformer;

use AppBundle\Util\PasswordUtil;
use Symfony\Component\Form\DataTransformerInterface;

class PasswordTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return null;
    }

    public function reverseTransform($value)
    {
        if ($value == null) {
            return null;
        }

        return PasswordUtil::encrypt($value);
    }

}