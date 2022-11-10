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
use Doctrine\ORM\Mapping\OneToMany;


#[Entity, Table(name: 'Gallery')]
final class Gallery
{
    #[Id, Column(name: 'id_gal', type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id_gal;

    #[Column(name: 'title', type: 'string', unique: false, nullable: false)]
    private string $title;

    #[Column(name: 'date_creation', type: 'string', unique: false, nullable: false)]
    private string $date_create;

    #[Column(name: 'private', type: 'boolean', unique: false, nullable: false)]
    private string $private;


    #[ManyToOne(targetEntity: User::class, inversedBy: 'Gallery')]
    #[JoinColumn(name: 'user_creator', referencedColumnName: 'id_user')]
    private User $user_creator;

    #[JoinTable(name: 'UserToGallery')]
    #[JoinColumn(name: 'id_gal', referencedColumnName: 'id_gal')]
    #[InverseJoinColumn(name: 'id_user', referencedColumnName: 'id_user')]
    #[ManyToMany(targetEntity: User::class)]
    private Collection $groups1;

    #[OneToMany(targetEntity: Gallery::class, mappedBy:'gallery')]
    private Collection $groups2;


    // #[JoinTable(name: 'ImageToGallery')]
    // #[JoinColumn(name: 'id_gal', referencedColumnName: 'id_gal')]
    // #[InverseJoinColumn(name: 'id_img', referencedColumnName: 'id_img')]
    // #[ManyToMany(targetEntity: Image::class)]


    public function __construct(string $title, string $date_create, string $private, User $user_creator)
    {
        $this->title = $title;
        $this->date_create = $date_create;
        $this->private = $private;
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
    public function getVisibility(): string
    {
        return $this->private;
    }
    public function getUser_Creator(): User
    {
        return $this->user_creator;
    }
    public function getUserToGallery(): Collection
    {
        return $this->groups1;
    }
    public function getImage(): Collection
    {
        return $this->groups2;
    }
}