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
use Doctrine\ORM\Tools\Pagination\Paginator;

class GalleryService
{
    private EntityManager $em;
    private LoggerInterface $logger;


    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function createGallery(string $title, string $date, bool $private, User $user_creator)
    {

        $gallery = new Gallery($title, $date, $private, $user_creator);
        $this->em->persist($gallery);
        $this->em->flush();
    }


    public function editGallery(int $id, string $title, bool $private)
    {
        $gallery = $this->em->getRepository(\App\Domain\Gallery::class)->find($id);;
        $gallery->setTitle($title);
        $gallery->setVisibility($private);
        $this->em->persist($gallery);
        $this->em->flush();
    }

    // public function deleteGallery(int $id)
    // {
    //     $gallery = $this->em->getRepository(\App\Domain\Gallery::class)->find($id);
    //     $this->em->remove($gallery);
    //     $users = $gallery->getUsertoGallery();
    //     $this->em->remove($users);
    //     $images = $gallery->getImageToGallery();
    //     $this->em->remove($images);
    //     $this->em->flush();
    // }

    public function getImageByGallery(int $id_gal)
    {
        $gallery = $this->em->getRepository(Gallery::class)->find($id_gal);

        return $gallery->getImages();
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
        $id_gal = $this->em->getRepository(\App\Domain\Gallery::class)->findBy(array(), ['id_gal' => 'DESC'], 1, 0);
        $id_user = $this->em->getRepository(\App\Domain\User::class)->findBy(['username' => $username]);
        $collection = $id_gal[0]->getUserToGallery();
        $collection->set($id_gal[0]->getId_gal(), $id_user[0]);
        $this->em->persist($id_gal[0]);
        $this->em->flush();
    }

    public function addImageGalerie($id_gal, $id_img)
    {
        //$collection = $this->gallery->getImageToGallery();

        //$collection->set($id_gal, $id_img);s
    }


    public function getGalleryById(int $id): Gallery
    {
        $gallery = $this->em->getRepository(\App\Domain\Gallery::class)->find($id);
        return $gallery;
    }

    public function getListImage(int $img): Paginator
    {
        $dql = "SELECT i FROM App\Domain\Image i";
        $query = $this->em->createQuery($dql)
            ->setFirstResult(5 * ($img - 1))
            ->setMaxResults(5);

        return new Paginator($query, $fetchJoinCollection = true);
    }

    public function getGalleryPublic(): array
    {
        $req = $this->em->getRepository(\App\Domain\Gallery::class)->findBy(['private' => 0]);
        $this->logger->info("GalleryService::getGalleryPublic()");

        return $req;
    }


    public function getGalleryPrivate(): array
    {
        $galleryPrivate = null;
        $req = $this->em->getRepository(\App\Domain\Gallery::class)->findBy(['private' => 1]);
        foreach ($req as $gallery) {
            $users = $gallery->getUserToGallery()->toArray();
            foreach ($users as $user) {
                if ($user->getId() === $_SESSION['id_user'] || $gallery->getUser_Creator()->getId() === $_SESSION['id_user']) {
                    $galleryPrivate[] = $gallery;
                }
            }


        }
        if($galleryPrivate === null){
            $galleryPrivate = [];
        }
        return $galleryPrivate;
    }

    public function connection()
    {
        //var_dump($_SESSION["id_user"]);
        if (isset($_SESSION["id_user"])) {
            //$game = $this->getByUser($_SESSION["user_id"]);
            $game = $this->em->getRepository(\App\Domain\User::class)->findBy(['id_user' => $_SESSION["id_user"]]);
            if ($game !== null) {
                return true;
            }
        } else {
            return false;
        }
    }
}
