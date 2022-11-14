<?php

namespace ImagesGallery;
session_start();

use App\Controller\UserController;
use App\Controller\GalleryController;
use App\Domain\Gallery;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$container = require_once __DIR__ . '/../bootstrap.php';

AppFactory::setContainer($container);


$app = AppFactory::create();

$app->add(TwigMiddleware::createFromContainer($app));

$app->get('/gallery', GalleryController::class . ':test');
$app->get('/', GalleryController::class . ':affichage');
$app->post('/login', UserController::class . ':login');
$app->post('/signup', UserController::class . ':signup');
$app->get('/logout', UserController::class . ':logout');
$app->get('/gallery/create', GalleryController::class . ':createGallery');
// $app->get('/gallery/delete/{id}', GalleryController::class . ':deleteGallery');
$app->get('/gallery/edit/{id}', GalleryController::class . ':editGallery');
$app->post('/gallery/edit', GalleryController::class . ':editGalleryPOST');
$app->get('/gallery/{id:[0-9]+}', GalleryController::class . ':getListGallery')->setName('maxgal');
$app->get('/gallery/{id:[0-9]+}/image/{id_img:[0-9]+}', GalleryController::class . ':getListImage')->setName('maximg');

$app->get('/gallery/{id}', GalleryController::class . ':getImageByGallery');

$app->post('/gallery/submit', GalleryController::class . ':createGalleryPOST');
$app->get('/image/add', GalleryController::class . ':addImageForm');
$app->post('/image/submit', GalleryController::class . ':addImagePOST');
$app->get('/user/create', UserController::class . ':Adduser');
$app->get('/about', UserController::class . ':displayAbout');
$app->get('/newGallery', UserController::class . ':newGallery');

//Clear session
$app->get('/deleteCache', function (Request $rq, Response $rs): Response {
    session_destroy();
    $rs = $rs->withStatus(302);
    return $rs->withHeader('Location', '/delete');
});

$app->run();
