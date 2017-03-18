<?php

namespace FrontendBundle\Form;

use Symfony\Component\Validator\Constraints as Assert;

class PasswordData
{

    /**
     * @Assert\NotBlank()
     */
    private $password;

    public static function builder()
    {
        return new PasswordData();
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

}