<?php

namespace App\Service;

use App\Domain\Gallery;
use App\Domain\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

class GalleryService
{
    private EntityManager $em;
    private LoggerInterface $logger;
    private Gallery $gallery;
    private User $user;


    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function createGallery(string $title, string $date, string $tag, bool $private, int $user_creator)
    {
        $gallery = new Gallery($title, $date, $tag, $private, $user_creator);

        $this->em->persist($gallery);
        $this->em->flush();
    }
    public function getListGallery(int $gal): Paginator
    {
        $dql = "SELECT g FROM App\Domain\Gallery g";
        $query = $this->em->createQuery($dql)
            ->setFirstResult(5 * ($gal - 1))
            ->setMaxResults(5);

        return new Paginator($query, $fetchJoinCollection = true);
    }

    public function getGalleryWithPosition(int $id): Gallery
    {
        $dql = "SELECT g FROM App\Domain\Gallery g WHERE g.id = :id";
        $query = $this->em->createQuery($dql)
            ->setParameter('id', $id);

        return $query->getSingleResult();
    }


    public function addUserPrivate($username)
    {
        $collection = $this->gallery->getUserToGallery();
        $id_gal = $collection->last();
        $id_user = $this->em->getRepository(\App\Domain\User::class)->findBy(['username' => $username]);
        $collection->set($id_gal, $id_user);
    }

    public function addImageGalerie($id_gal, $id_img)
    {
        $collection = $this->gallery->getImageTogallery();

        $collection->set($id_gal, $id_img);
    }

    public function getGalleryById(int $id): Gallery
    {
        $gallery = $this->em->getRepository(Gallery::class)->find($id);
        return $gallery;
    }

    public function deleteGallery(int $id)
    {
        $gallery = $this->getGalleryById($id);
        $this->em->remove($gallery);
        $this->em->flush();
    }

    public function getListImage(int $img): Paginator
    {
        $dql = "SELECT i FROM App\Domain\Image i";
        $query = $this->em->createQuery($dql)
            ->setFirstResult(5 * ($img - 1))
            ->setMaxResults(5);

        return new Paginator($query, $fetchJoinCollection = true);
    }

}
