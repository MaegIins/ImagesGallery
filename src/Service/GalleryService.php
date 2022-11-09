<?php

namespace App\Service;

use App\Domain\Gallery;
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

    public function addUserPrivate($id_gal, $id_user)
    {
        $collection = $this->gallery->getUserToGallery();

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

}
