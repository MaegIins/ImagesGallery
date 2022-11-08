<?php

namespace App\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;


#[Entity, Table(name: 'usertogalery')]


final class GaleryToImage
{
    #[Id, Column(name: 'id_user', type: 'integer')]
    private int $id_img;

    #[Id, Column(name: 'id_gal', type: 'integer', unique: false, nullable: false)]
    private string $id_gal;


    public function __construct(string $id_user, string $id_gal)
    {
        $this->id_img = $id_user;
        $this->id_gal = $id_gal;
    }
    public function getId_user(): int
    {
        return $this->user;
    }
    public function getId_gal(): string
    {
        return $this->id_gal;
    }
}
