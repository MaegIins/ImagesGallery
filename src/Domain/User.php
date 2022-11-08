<?php

namespace App\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'user')]
final class User
{
    #[Id, Column(name: 'id_user', type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id_user;

    #[Column(name: 'name', type: 'string', unique: false, nullable: false)]
    private string $name;

    #[Column(name: 'first_name', type: 'string', unique: false, nullable: false)]
    private string $first_name;

    #[OneToMany(targetEntity: Galery::class, mappedBy:'user')]

    #[Column(name: 'name', type: 'string', unique: false, nullable: false)]
    private string $name;

    #[Column(name: 'first_name', type: 'string', unique: false, nullable: false)]
    private string $first_name;


    #[Column(name: 'email', type: 'string', unique: false, nullable: false)]
    private string $email;

    #[Column(name: 'password', type: 'string', unique: false, nullable: false)]
    private string $password;




    public function __construct(string $id_user, string $name, string $first_name, string $email, string $password)
    {
        $this->id_user = $id_user;
        $this->name = $name;
        $this->first_name = $first_name;
        $this->email = $email;
        $this->password = $password;

    }
    public function getId_user(): int
    {
        return $this->id_user;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getFirstName(): string
    {
        return $this->first_name;
    }
    }
    public function getId_user(): int
    {
        return $this->id_user;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
}
