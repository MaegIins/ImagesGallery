<?php

namespace App\Controller;

use App\Service\GalleryService;

class GaleryController
{
    private $view;
    private GalleryService $galleryService;

    public function __construct(Twig $view, GalleryService $galleryService)
    {
        $this->view = $view;
        $this->galleryService = $galleryService;
    }


    public function affichage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        if ($this->connection() === false) {
            $gallery = $this->galleryService->getGalleryPublic();

            return $this->view->render($response, 'gallery.twig', [
                'conn' => isset($_SESSION['user_id']),
                'name' => $_SESSION["username"] ?? "",
                'gallery' => $gallery
            ]);
        } else {
            $galleryPublic = $this->galleryService->getGallery();
            $galleryPrivate = $this->galleryService->getGalleryPrivate();
            $gallery = array_merge($galleryPublic, $galleryPrivate);

            return $this->view->render($response, 'gallery.twig', [
                'conn' => isset($_SESSION['user_id']),
                'name' => $_SESSION["username"] ?? "",
                'gallery' => $gallery
            ]);

        }
    }
}