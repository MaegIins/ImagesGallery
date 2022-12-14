<?php

use App\Controller\UserController;
use App\Controller\GalleryController;
use App\Domain\AssignmentImage;
use App\Service\AssignmentImageService;
use App\Service\GalleryService;
use App\Service\UserService;
use App\Service\ImageService;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use UMA\DIC\Container;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;


require_once __DIR__ . '/vendor/autoload.php';

$container = new Container(require __DIR__ . '/settings.php');

$container->set(LoggerInterface::class, function (ContainerInterface $c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Logger($settings['name']);
    $logger->pushHandler(new StreamHandler($settings['path'], Level::Debug));
    return $logger;
});

$container->set(EntityManager::class, static function (Container $c): EntityManager {
    /** @var array $settings */
    $settings = $c->get('settings');

    // Use the ArrayAdapter or the FilesystemAdapter depending on the value of the 'dev_mode' setting
    // You can substitute the FilesystemAdapter for any other cache you prefer from the symfony/cache library
    $cache = $settings['doctrine']['dev_mode'] ?
        DoctrineProvider::wrap(new ArrayAdapter()) :
        DoctrineProvider::wrap(new FilesystemAdapter(directory: $settings['doctrine']['cache_dir']));

    $config = Setup::createAttributeMetadataConfiguration(
        $settings['doctrine']['metadata_dirs'],
        $settings['doctrine']['dev_mode'],
        null,
        $cache
    );

    return EntityManager::create($settings['doctrine']['connection'], $config);
});

$container->set('view', function () {
    return Twig::create(
        __DIR__ . '/public/view');
});

$container->set(UserService::class, static function (Container $c) {
    return new UserService($c->get(EntityManager::class), $c->get(LoggerInterface::class));
});

$container->set(ImageService::class, static function (Container $c) {
    return new ImageService($c->get(EntityManager::class), $c->get(LoggerInterface::class));
});

$container->set(AssignmentImageService::class, static function (Container $c) {
    return new AssignmentImageService($c->get(EntityManager::class), $c->get(LoggerInterface::class));
});

$container->set(UserController::class, static function (ContainerInterface $container) {
    $view = $container->get('view');
    return new UserController($view, $container->get(UserService::class));
});

$container->set(GalleryService::class, static function (Container $c) {
    return new GalleryService($c->get(EntityManager::class), $c->get(LoggerInterface::class));
});

$container->set(GalleryController::class, static function (ContainerInterface $container) {
    $view = $container->get('view');
    return new GalleryController($view, $container->get(GalleryService::class), $container->get(UserService::class),$container->get(ImageService::class),$container->get(AssignmentImageService::class),$container->get(LoggerInterface::class));
});

return $container;
