<?php

namespace App\Service;

use App\Domain\Galery;
use App\Domain\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Log\LoggerInterface;

class GalleryService
{
    private EntityManager $em;
    private LoggerInterface $logger;
    private Galery $gallery;
    private User $user;

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
        $id_user = $this->em->getRepository(\App\Domain\User::class)->findBy(['username' => $username]);
        $collection->set($id_gal, $id_user);
    }

    public function addImageGalerie($id_gal, $id_img)
    {
        $collection = $this->gallery->getImageTogalery();

        $collection->set($id_gal, $id_img);
    }


    public function getGalleryPublic(): array
    {
        $req = $this->em->getRepository(\App\Domain\Gallery::class)->findBy(['private' => false]);
        $this->logger->info("GalleryService::getGalleryPublic()");
        return $req;
    }


    public function getGalleryPrivate(): array
    {
        $galleryPrivate[] = "";
        $req = $this->em->getRepository(\App\Domain\Gallery::class)->findBy(['private' => true]);
        foreach ($req as $gallery) {
            $users = $gallery->getGroups1();
            if ($users->contains($_SESSION["user_id"])) {
                arraypush($galleryPrivate[], $gallery);
            }
        }

        return $galleryPrivate;
    }

    public function connection()
    {
        if (isset($_SESSION["user_id"])) {
            $game = $this->getByUser($_SESSION["user_id"]);
            if ($game !== null) {
                return true;
            }
        } else {
            return false;
        }
    }


}
