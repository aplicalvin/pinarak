<?php 

namespace App\Routes;

use App\Controller\AuthController;
use App\Controller\HomeController;
use App\Router;

$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->get('/login', AuthController::class, 'index');
$router->post('/login', AuthController::class, 'login');
$router->get('/logout', AuthController::class, 'logout');

$router->dispatch();
