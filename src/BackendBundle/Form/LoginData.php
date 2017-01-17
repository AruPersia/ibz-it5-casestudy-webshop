<?php

namespace BackendBundle\Form;

use CoreBundle\Util\PasswordUtil;
use Symfony\Component\Validator\Constraints as Assert;

class LoginData
{

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @Assert\NotBlank()
     */
    private $password;

    public static function builder()
    {
        return new LoginData();
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = PasswordUtil::encrypt($password);
        return $this;
    }

}