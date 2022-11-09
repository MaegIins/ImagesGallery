<?php

namespace App\Service;

class GalleryService
{
    private EntityManager $em;
    private LoggerInterface $logger;

    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
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


    public function getByTag(string $tag): array
    {
        $galleryTag[] = "";
        $req = $this->em->getRepository(\App\Domain\Galery::class)->findAll();
        foreach ($req as $gallery) {
            $tags = $gallery->getTags();
            $tagstab[] = $tags->explode(",");
            if ($tagstab->contains($tag)) {
                arraypush($galleryTag, $gallery);
            }
        }
        $this->logger->info("GalleryService::getByTag()");
        return $galleryTag;
    }
}