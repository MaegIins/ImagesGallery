<?php

namespace App\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'Image')]
final class Image
{
    #[Id, Column(name: 'id_img', type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id_img;

    #[OneToMany(targetEntity: Image::class, mappedBy:'image')]
    private Collection $groups;

    #[Column(name: 'tag', type: 'string', unique: false, nullable: false)]
    private string $tag;

    #[Column(name: 'path', type: 'string', unique: false, nullable: false)]
    private string $path;


    public function __construct(string $tag, string $path)
    {
        $this->tag = $tag;
        $this->path = $path;
        $this->groups = new ArrayCollection();
    }
    public function getId_img(): int
    {
        return $this->id_img;
    }
    public function getTag(): string
    {
        return $this->tag;
    }
    public function getPath(): string
    {
        return $this->path;
    }
    public function getGallery(): Collection
    {
        return $this->groups;
    }
}
