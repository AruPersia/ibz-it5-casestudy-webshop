<?php

namespace CoreBundle\Model;

use CoreBundle\Util\ValidateUtil;

class Image
{

    private $id;
    private $binary;

    public function __construct($id, $binary)
    {
        $this->id = $id;
        $this->binary = ValidateUtil::notNull($binary);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getBinary()
    {
        return $this->binary;
    }

    public function toBase64()
    {
        return base64_encode(stream_get_contents($this->binary));
    }

}