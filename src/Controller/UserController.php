<?php

namespace App\Controller;

use App\Service\UserService;
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
    private UserService $userService;

    public function __construct(Twig $view, UserService $userService)
    {
        $this->view = $view;
        $this->userService = $userService;
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
        //okesc
    public function start(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        return $this->view->render($response, 'gallery.twig', [
            'conn' => isset($_SESSION['id_user']),
            'name' => $_SESSION["name"] ?? "",
            'errorLogin' => "",
            'errorSignup' => ""
        ]);
    }

    public function login(ServerRequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $args = $request->getParsedBody();
        $errorLogin = "";
        if (isset($args["name"]) && isset($args["password"])) {


            $login = $this->userService->login($args["name"], $args["password"]);
            if ($login === false) {
                $errorLogin = "Wrong name or password";

            } else {
                $_SESSION["id_user"] = $login;
                $_SESSION["name"] = $args["name"];
            }
        }

        return $this->view->render($response, 'gallery.twig', [
            'conn' => isset($_SESSION['id_user']),
            'name' => $_SESSION["name"] ?? "",
            'errorLogin' => $errorLogin
        ]);
    }

    /**
     * @throws OptimisticLockException
     * @throws SyntaxError
     * @throws ORMException
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function signup(ServerRequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $args = $request->getParsedBody();
        if (isset($args["name"]) && isset($args["password"]) && isset($args["password_confirm"])) {
            $signup = $this->userService->signup($args["name"], $args["password"], $args["password_confirm"]);
            if ($signup === false) {
                if ($args["password"] != $args["password_confirm"]) {
                    $errorSignup = "Les mots de passe ne correspondent pas / Ne sont pas assez longs";
                } else {

                    $errorSignup = "Le nom d'utilisateur est déjà utilisé Les mots de passe ne correspondent pas / Ne sont pas assez longs ";
                }
            } else {
                $_SESSION["id_user"] = $signup;
                $_SESSION["name"] = $args["name"];
                $errorSignup = "Inscription réussie";
            }
        } else {
            $errorSignup = "Veuillez remplir tous les champs";
        }
        return $this->view->render($response, 'gallery.twig', [
            'conn' => isset($_SESSION['id_user']),
            'name' => $_SESSION["name"] ?? "",
            'errorSignup' => $errorSignup
        ]);
    }

    public function logout(ServerRequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        unset($_SESSION["id_user"]);
        unset($_SESSION["name"]);
        $response = $response->withStatus(302);
        return $response->withHeader('Location', '/');
    }//helloo aled
}
