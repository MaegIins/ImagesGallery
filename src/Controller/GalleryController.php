<?php

namespace App\Controller;

use App\Service\GalleryService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class UserController
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
        $args = $request->getParsedBody();
        if (isset($args["title"]) && isset($args["tag"]) && isset($args["radio-group"])) {
            $title = filter_var($args['title'], FILTER_UNSAFE_RAW);
            $tag = filter_var($args['tag'], FILTER_UNSAFE_RAW);
            $private = $args['radio-group'];
            $user_creator = $_SESSION[''];
            $this->galleryService->createGallery($title, date('l jS \of F Y h:i:s A'), $tag, $private, $user_creator);
        }
    }
}
