<?php

namespace CoreBundle\Model;

class ImageBuilder implements Builder
{

    private $id;
    private $binary;

    private function __construct()
    {
        // private constructor
    }

    public static function instance(): ImageBuilder
    {
        return new ImageBuilder();
    }

    public function build(): Image
    {
        return new Image($this->id, $this->binary);
    }

    public function setId($id): ImageBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function setBinary($binary): ImageBuilder
    {
        $this->binary = $binary;
        return $this;
    }

}