<?php
define('ROOT_DIR', realpath(dirname(__DIR__)));
include __DIR__ . '/../Apps/bootstrap.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$router = new \Bramus\Router\Router();

require __DIR__ . '/../Apps/Libs/Router.php';
require __DIR__ . '/../Apps/Libs/UserRouter.php';
require __DIR__ . '/../Apps/Libs/DestRouter.php';
require __DIR__ . '/../Apps/Libs/BlogRouter.php';




$router->run();
