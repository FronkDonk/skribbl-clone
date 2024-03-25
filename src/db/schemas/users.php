<?php

namespace src\db\schemas;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Column;
use DateTime;

#[Entity]
#[Table(name: 'users')]

class User
{
    #[Id, GeneratedValue, Column(type: "integer")]
    private $id;

    #[Column(type: "string")]
    private $name;

    #[Column(type: "string")]
    private $email;

    #[Column(type: "string")]
    private $password;

    #[Column(type: "datetime")]
    private $created_at;

    #[Column(type: "datetime")]
    private $email_verified;

    public function __construct($name, $email, $password, $email_verified, $created_at)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->created_at = new DateTime();
        $this->email_verified = $email_verified;
        $this->created_at = $created_at;
    }

    public function getUser()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'email_verified' => $this->email_verified,
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getEmailVerified()
    {
        return $this->email_verified;
    }
}
