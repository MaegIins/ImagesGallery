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
//if (isset($args["title"]) && isset($args["tag"]) && isset($args["radio-group"]) && isset($_FILES) && isset($args["username"])) {
            $title = filter_var($args['title'], FILTER_UNSAFE_RAW);
            $tag = filter_var($args['tag'], FILTER_UNSAFE_RAW);

            if ($args['groupe-radio'] == "prive") {
                $private = true;
            } else {
                $private = false;
            }
        echo "sss";
            //$user_creator = $_SESSION['user_id'];
            $user_creator = 2;
            echo "test";
            $this->galleryService->createGallery($title, date('l jS \of F Y h:i:s A'), $tag, $private, $user_creator);

            $username = $args["username"];
            $this->galleryService->addUserPrivate($username);
            var_dump($this->galleryService->addUserPrivate($username));
       // }

        return $this->view->render($response, 'createGal.twig', [
            'conn' => isset($_SESSION['user_id']),
            'name' => $_SESSION["username"] ?? "",
            'error' => ""
        ]);
    }
}
