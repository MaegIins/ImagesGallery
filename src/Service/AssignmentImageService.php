<?php

namespace App\Service;

use App\Domain\AssignmentImage;
use App\Domain\Gallery;
use App\Domain\Image;
use App\Domain\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AssignmentImageService
{
    private EntityManager $em;
    private LoggerInterface $logger;


    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function createAssignmentImage(Gallery $gallery, Image $img, string $date_add)
    {
        $as = new AssignmentImage($gallery, $img, $date_add);
        $this->em->persist($as);
        $this->em->flush();
    }




    public function assignmentImage()
    {
        $id_gal = $this->em->getRepository(\App\Domain\Gallery::class)->findBy(array(), ['id_gal' => 'DESC'], 1, 0);
        $img = $this->em->getRepository(\App\Domain\Image::class)->findBy(array(), ['id_img' => 'DESC'], 1, 0);
        $as = $this->createAssignmentImage($id_gal[0], $img[0], date('l jS \of F Y h:i:s A'));
    }

    public function assignmentImageWithIdGallery($id_gal)
    {
        $img = $this->em->getRepository(\App\Domain\Image::class)->findBy(array(), ['id_img' => 'DESC'], 1, 0);
        $as = $this->createAssignmentImage($id_gal, $img[0], date('l jS \of F Y h:i:s A'));
    }
}
