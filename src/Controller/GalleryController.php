<?php

namespace App\Controller;

use App\Service\AssignmentImageService;
use App\Service\GalleryService;
use App\Service\ImageService;
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
    private ImageService $imageService;
    private AssignmentImageService $assignmentImageService;

    public function __construct(Twig $view, GalleryService $galleryService, UserService $userService, ImageService $imageService, AssignmentImageService $assignmentImageService)
    {
        $this->view = $view;
        $this->galleryService = $galleryService;
        $this->userService = $userService;
        $this->imageService = $imageService;
        $this->assignmentImageService = $assignmentImageService;
    }

    public function test(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->view->render($response, 'galleryWithPhoto.twig');
    }


    public function createGallery(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->view->render($response, 'createGal.twig', [
            'conn' => isset($_SESSION['id_user']),
            'name' => $_SESSION["name"] ?? "",
            'error' => ""
        ]);
    }

    public function editGallery(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = $args['id'];
        $gallery = $this->galleryService->getGalleryById($id);
        return $this->view->render($response, 'editGal.twig', [
            'conn' => isset($_SESSION['user_id']),
            'name' => $_SESSION["name"] ?? "",
            'error' => "",
            'gallery' => $gallery
        ]);
    }

    public function createGalleryPOST(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $args = $request->getParsedBody();
        if (isset($args["title"]) && isset($args["tag"]) && isset($args["groupe-radio"]) && isset($_FILES) && isset($args["user"])) {
            $title = filter_var($args['title'], FILTER_UNSAFE_RAW);
            $tag = filter_var($args['tag'], FILTER_UNSAFE_RAW);

            if ($args['groupe-radio'] == "prive") {
                $private = true;
            } else {
                $private = false;
            }
            $user = $_SESSION['id_user'];
            $user_creator = $this->userService->findUserById($user);
            $this->galleryService->createGallery($title, date('l jS \of F Y h:i:s A'), $private, $user_creator);

            $username = $args["user"];
            $this->galleryService->addUserPrivate($username);
            foreach ($_FILES as $img) {
                $id = rand(0,2000);
                move_uploaded_file($img['tmp_name'],'../public/data/img/'.$id.$img["name"]);
            $this->imageService->createImage($args["tag"],'/public/data/img/'.$id.$img["name"]);
            $this->assignmentImageService->assignmentImage();
            }


        }

        return $this->view->render($response, 'galleryWithPhoto.twig', [
            'conn' => isset($_SESSION['id_user']),
            'name' => $_SESSION["name"] ?? "",
            'error' => ""
        ]);
    }


    public function affichage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        if ($this->galleryService->connection() === false) {
            $gallery = $this->galleryService->getGalleryPublic();

            return $this->view->render($response, 'gallery.twig', [
                'conn' => isset($_SESSION['id_user']),
                'name' => $_SESSION["name"] ?? "",
                'galleryPublic' => $gallery
            ]);
        } else {
            $galleryPublic = $this->galleryService->getGalleryPublic();
            $galleryPrivate = $this->galleryService->getGalleryPrivate();

            return $this->view->render($response, 'gallery.twig', [
                'conn' => isset($_SESSION['id_user']),
                'name' => $_SESSION["name"] ?? "",
                'galleryPr' => $galleryPrivate,
                'galleryPu' => $galleryPublic,
            ]);

        }
    }



    public function getListGallery(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $args = $request->getQueryParams();
        if (isset($args["id_gal"])) {
            $nbgal = filter_var($args['id_gal'], FILTER_SANITIZE_NUMBER_INT);
            $maxgallery = $this->galleryService->getListGallery($nbgal);
            return $this->view->render($response, 'gallery.twig', ['gallery' => $maxgallery]);
        }
    }

    public function getListImageAtGallery(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $args = $request->getQueryParams();
        if (isset($args["id_img"])) {
            $id_gal = filter_var($args['id_img'], FILTER_SANITIZE_NUMBER_INT);
            $maximg = $this->galleryService->getGalleryWithPosition($id_gal);
            return $this->view->render($response, 'gallery.twig', ['image' => $maximg]);
        }
    }
}



