<?php

namespace CoreBundle\Model;

interface Builder
{
    public static function instance();

    public function build();
}