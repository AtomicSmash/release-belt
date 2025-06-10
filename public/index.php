<?php

declare(strict_types=1);

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;
use AtomicSmash\ReleaseBelt\Controller\FileController;
use AtomicSmash\ReleaseBelt\Controller\IndexController;
use AtomicSmash\ReleaseBelt\Controller\JsonController;
use AtomicSmash\ReleaseBelt\Provider\AuthenticationProvider;
use RKA\Middleware\IpAddress;

require __DIR__ . '/../vendor/autoload.php';

$configPath = __DIR__ . '/../config/config.php';
$builder    = new ContainerBuilder();

$builder->addDefinitions(__DIR__ . '/../src/definitions.php');

if (file_exists($configPath)) {
    $builder->addDefinitions($configPath);
}

$container = $builder->build();
$app       = Bridge::create($container);

$app->get('/', IndexController::class)->setName('index');
$app->get('/packages.json', JsonController::class)->setName('json');
$app->get('/{vendor}/{file}', FileController::class)->setName('file');

$app->add(new IpAddress());

$authentication = new AuthenticationProvider();
$authentication->boot($app);

$app->addErrorMiddleware((bool)$container->get('debug'), true, true);

$app->run();
