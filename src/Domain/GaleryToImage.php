<?php

namespace App\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'galerytoimage')]
final class GaleryToImage

#[Entity, Table(name: 'g1')]
final class GaleryToImage2

{
    #[Id, Column(name: 'id_img', type: 'integer')]
    private int $id_img;

    #[Id, Column(name: 'id_gal', type: 'integer', unique: false, nullable: false)]
    private string $id_gal;

    #[Column(name: 'date_add', type: 'date', unique: false, nullable: false)]
    private string $date_add;


    public function __construct(string $id_img, string $id_gal, string $date_add)
    {
        $this->id_img = $id_img;
        $this->id_gal = $id_gal;
        $this->date_add = $date_add;
    }
    public function getId_img(): int
    {
        return $this->id_img;
    }
    public function getId_gal(): string
    {
        return $this->id_gal;
    }
    public function getDate_add(): string
    {
        return $this->date_add;
    }
}
