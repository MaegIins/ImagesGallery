<?php

namespace App\Service;

use App\Domain\Gallery;
use App\Domain\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Log\LoggerInterface;
class GalleryService
{
    private EntityManager $em;
    private LoggerInterface $logger;

    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function createGallery(string $title, string $date, string $tag, bool $private, User $user_creator)
    {   
        $gallery = new Gallery($title, $date, $tag, $private, $user_creator);
        $this->em->persist($gallery);
        $this->em->flush();
    }

    public function addUserPrivate($username)
    {
        $id_gal = $this->em->getRepository(\App\Domain\Gallery::class)->findBy(array(), ['id_gal' => 'DESC'],1,0);
        $id_user = $this->em->getRepository(\App\Domain\User::class)->findBy(['username' => $username]);
        $collection = $id_gal[0]->getUserToGallery();
        $collection->set($id_gal[0]->getId_gal(), $id_user[0]);
        $this->em->persist($id_gal[0]);
        $this->em->flush();
    }

    public function addImageGalerie($id_gal, $id_img)
    {
        //$collection = $this->gallery->getImageToGallery();

        //$collection->set($id_gal, $id_img);
    }


}
