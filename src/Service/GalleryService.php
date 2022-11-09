<?php

namespace App\Service;

use App\Domain\Galery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Log\LoggerInterface;
class GalleryService
{
    private EntityManager $em;
    private LoggerInterface $logger;
    private Galery $gallery;

    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function createGallery(string $title, string $date, string $tag, bool $private, int $user_creator)
    {
        $gallery = new Galery($title, $date, $tag, $private, $user_creator);

        $this->em->persist($gallery);
        $this->em->flush();
    }

    public function addUserPrivate($username)
    {
        $collection = $this->gallery->getUserToGalery();
        $id_gal = $collection->last();
        $id_user = 
        $collection->set($id_gal, $id_user);
    }

    public function addImageGalerie($id_gal, $id_img)
    {
        $collection = $this->gallery->getImageTogalery();

        $collection->set($id_gal, $id_img);
    }


}
