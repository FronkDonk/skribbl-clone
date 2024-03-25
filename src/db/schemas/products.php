<?php

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Column;


#[Entity]
#
#[Table(name: 'products')]

class Product {
    #[Id, GeneratedValue, Column(type: "integer")]
    private $id;

    #[Column(type: "string")]
    private $name;

    #[Column(type: "string")]
    private $description;

    #[Column(type: "decimal", scale: 2)]
    private $price;

    public function getId(): ?int {
        return $this->id;
    }
    

    public function getName(): ?string {
        return $this->name;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function getPrice(): ?float {
        return $this->price;
    }

}