<?php
namespace ImagesGallery;
session_start();
use App\Controller\UserController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$container = require_once __DIR__ . '/../bootstrap.php';

AppFactory::setContainer($container);

$app = AppFactory::create();

$app->add(TwigMiddleware::createFromContainer($app));





$app->get('/', UserController::class . ':start');
$app->post('/login', UserController::class . ':login');
$app->post('/signup', UserController::class . ':signup');
$app->get('/logout', UserController::class . ':logout');

//Clear session
$app->get('/deleteCache', function (Request $rq, Response $rs): Response {
    session_destroy();
    $rs = $rs->withStatus(302);
    return $rs->withHeader('Location', '/delete');
});


$app->run();
