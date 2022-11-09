<?php

namespace App\Controller;

use App\Domain\User;
use App\Service\GalleryService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GalleryController
{
    private $view;
    private GalleryService $galleryService;

    public function __construct(Twig $view, GalleryService $galleryService)
    {
        $this->view = $view;
        $this->galleryService = $galleryService;
    }

    public function createGallery(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->view->render($response, 'createGal.twig', [
            'conn' => isset($_SESSION['user_id']),
            'name' => $_SESSION["username"] ?? "",
            'error' => ""
        ]);
    }

    public function createGalleryPOST(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $args = $request->getParsedBody();
        var_dump($args);
        var_dump($_FILES);
        if (isset($args["title"]) && isset($args["tag"]) && isset($args["radio-group"]) && isset($_FILES)) {
            $title = filter_var($args['title'], FILTER_UNSAFE_RAW);
            $tag = filter_var($args['tag'], FILTER_UNSAFE_RAW);

            if ($args['radio-group'] == "prive") {
                $private = true;
            } else {
                $private = false;
            }


            $user_creator = $_SESSION['user_id'];
            $this->galleryService->createGallery($title, date('l jS \of F Y h:i:s A'), $tag, $private, $user_creator);
        }

        return $this->view->render($response, 'createGal.twig', [
            'conn' => isset($_SESSION['user_id']),
            'name' => $_SESSION["username"] ?? "",
            'error' => ""
        ]);
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
