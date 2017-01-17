<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\MappedSuperclass
 * @package CoreBundle\Entity
 */
class MappedUserInterface implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $password;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getRoles()
    {
        return explode(';', $this->roles);
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function serialize()
    {
        return serialize([$this->id, $this->email, $this->password]);
    }

    public function getSalt()
    {
        return '5=q@476usj-#@1yQjSH496pcT5CEbzjD';
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function eraseCredentials()
    {
        // TODO AFS: Implement if needed
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password
            ) = unserialize($serialized);
    }


}