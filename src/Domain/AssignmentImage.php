<?php

namespace App\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'AssignmentImage')]
final class AssignmentImage
{

    #[ManyToOne(targetEntity: Gallery::class, inversedBy: 'Gallery')]
    #[Id, JoinColumn(name: 'id_gal', referencedColumnName: 'id_gal')]
    private Gallery $id_gal;

    #[ManyToOne(targetEntity: Image::class, inversedBy: 'Image')]
    #[Id, JoinColumn(name: 'id_img', referencedColumnName: 'id_img')]
    private Image $id_img;


    #[Column(name: 'date_add', type: 'string')]
    private string $date_add;


    public function __construct( Gallery $id_gal, Image $id_img, string $date_add)
    {
        $this->id_gal = $id_gal;
        $this->id_img = $id_img;
        $this->date_add = $date_add;
    }
    public function getId_gal(): Gallery
    {
        return $this->id_gal;
    }
    public function getId_img(): Image
    {
        return $this->id_img;
    }
    public function getDate_add(): string
    {
        return $this->date;
    }
}
