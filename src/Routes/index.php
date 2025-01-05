<?php 

namespace App\Routes;

use App\Controller\AuthController;
use App\Controller\HomeController;
use App\Router;

$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->get('/login', AuthController::class, 'loginPage');
$router->post('/login', AuthController::class, 'login');
$router->get('/register', AuthController::class, 'registerPage');
$router->post('/register', AuthController::class, 'register');
$router->get('/logout', AuthController::class, 'logout');

$router->dispatch();
