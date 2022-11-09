<?php

namespace App\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\InverseJoinColumn;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;

#[Entity, Table(name: 'Gallery')]
final class Galery
{
    #[Id, Column(name: 'id_gal', type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id_gal;

    #[Column(name: 'title', type: 'string', unique: false, nullable: false)]
    private string $title;

    #[Column(name: 'date_creation', type: 'date', unique: false, nullable: false)]
    private string $date_create;

    #[Column(name: 'tag', type: 'string', unique: false, nullable: false)]
    private string $tag;

    #[Column(name: 'private', type: 'boolean', unique: false, nullable: false)]
    private string $private;


    #[ManyToOne(targetEntity: User::class, inversedBy: 'galery')]
    #[JoinColumn(name: 'user_creator', referencedColumnName: 'id_user')]
    private User $user_creator;

    #[JoinTable(name: 'UserToGalery')]
    #[JoinColumn(name: 'id_gal', referencedColumnName: 'id_gal')]
    #[InverseJoinColumn(name: 'id_user', referencedColumnName: 'id_user')]
    #[ManyToMany(targetEntity: User::class)]
    private Collection $groups1;

    #[JoinTable(name: 'ImageToGalery')]
    #[JoinColumn(name: 'id_gal', referencedColumnName: 'id_gal')]
    #[InverseJoinColumn(name: 'id_img', referencedColumnName: 'id_img')]
    #[ManyToMany(targetEntity: Image::class)]
    private Collection $groups2;



    public function __construct(string $title, string $date_create, string $tag, string $private, User $user_creator)
    {
        $this->name = $title;
        $this->first_name = $date_create;
        $this->email = $tag;
        $this->password = $private;
        $this->user_creator = $user_creator;
        $this->groups1 = new ArrayCollection();
        $this->groups2 = new ArrayCollection();

    }
    public function getId_gal(): int
    {
        return $this->id_gal;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function getDate_Create(): string
    {
        return $this->date_create;
    }
    public function getTag(): string
    {
        return $this->tag;
    }
    public function getVisibility(): string
    {
        return $this->private;
    }
    public function getUser_Creator(): User
    {
        return $this->user_creator;
    }
    public function getUserToGalery(): Collection
    {
        return $this->groups1;
    }
    public function getImageTogalery(): Collection
    {
        return $this->groups2;
    }
}