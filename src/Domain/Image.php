<?php

namespace App\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'image')]
final class Image
{
    #[Id, Column(name: 'id_img', type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id_img;

    #[Column(name: 'tag', type: 'string', unique: false, nullable: false)]
    private string $tag;

    #[Column(name: 'path', type: 'string', unique: false, nullable: false)]
    private string $path;


    public function __construct(string $id_img, string $tag, string $path)
    {
        $this->id_img = $id_img;
        $this->tag = $tag;
        $this->path = $path;
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
}
