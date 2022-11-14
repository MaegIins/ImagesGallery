<?php

namespace App\Service;

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

class ImageService
{
    private EntityManager $em;
    private LoggerInterface $logger;


    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function createImage(string $tag, string $path)
    {
        $gallery = new Image($tag, $path);
        $this->em->persist($gallery);
        $this->em->flush();
    }
    public function getImageByUser(): array
    {

    }
}
