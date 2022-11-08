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
        $req = $this->em->getRepository(\App\Domain\Gallery::class)->findBy(['private' => true]);
        foreach ($req as $gallery) {
            $users = $gallery->getGroups1();
            if($users->contains($_SESSION["user_id"])){
                $galleryPrivate[] = $gallery;
            }
        }

        return $galleryPrivate;
    }

    public function connection()
    {
        if (isset($_SESSION["user_id"])) {
            $game = $this->getByUser($_SESSION["user_id"]);
            if ($game !== null) {
                $_SESSION["user_penality"] = json_decode($game->getUserPenality(), true);
                $_SESSION["starting_timer"] = json_decode($game->getStartingTimer(), true);
                $_SESSION["currents_cards"] = json_decode($game->getCurrentsCards(), true);
                unset($_SESSION["user_time"]);
                return true;
            }
        }
        return false;
    }
}