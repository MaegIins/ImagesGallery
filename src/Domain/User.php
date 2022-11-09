<?php

namespace App\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'User')]
final class User
{
    #[Id, Column(name: 'id_user', type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id_user;

    #[OneToMany(targetEntity: Gallery::class, mappedBy:'user')]

    #[Column(name: 'name', type: 'string', unique: false, nullable: false)]
    private string $name;

    #[Column(name: 'first_name', type: 'string', unique: false, nullable: true)]
    private string $first_name;


    #[Column(name: 'email', type: 'string', unique: false, nullable: true)]
    private string $email;

    #[Column(name: 'password', type: 'string', unique: false, nullable: false)]
    private string $password;




    public function __construct( string $name,  string $password)
    {
        $this->name = $name;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    public function getId(): int
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
    public function checkPassword($pass) : bool {
        return password_verify($pass, $this->password);
    }
}
