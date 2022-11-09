<?php

namespace App\Controller;

use App\Service\GalleryService;
use App\Service\UserService;
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
    private UserService $userService;

    public function __construct(Twig $view, GalleryService $galleryService, UserService $userService)
    {
        $this->view = $view;
        $this->galleryService = $galleryService;
        $this->userService = $userService;
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
//if (isset($args["title"]) && isset($args["tag"]) && isset($args["radio-group"]) && isset($_FILES) && isset($args["username"])) {
            $title = filter_var($args['title'], FILTER_UNSAFE_RAW);
            $tag = filter_var($args['tag'], FILTER_UNSAFE_RAW);

            if ($args['groupe-radio'] == "prive") {
                $private = true;
            } else {
                $private = false;
            }
            //$user_creator = $_SESSION['user_id'];
            $user_creator = $this->userService->findUserById(2);
            $this->galleryService->createGallery($title, date('l jS \of F Y h:i:s A'), $tag, $private, $user_creator);

            $username = $args["user"];
            $this->galleryService->addUserPrivate($username);
       // }

        return $this->view->render($response, 'createGal.twig', [
            'conn' => isset($_SESSION['user_id']),
            'name' => $_SESSION["username"] ?? "",
            'error' => ""
        ]);
    }
}
