<?php

namespace BackendBundle\Form;

use Symfony\Component\Validator\Constraints as Assert;

class CategoryData
{

    /**
     * @Assert\NotBlank()
     * TODO AAF: Nice to hav -> category path validation with regex
     */
    private $path;

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

}

