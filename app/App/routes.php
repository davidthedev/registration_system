<?php
/**
 * This a routes file when Router class is instantiated and routes are added.
 * @var App
 */
$router = new App\Core\Router;
$router->addRoute('', ['controller' => 'Home', 'method' => 'index']);
$router->addRoute('about', ['controller' => 'Home', 'method' => 'about']);
$router->addRoute('contact', ['controller' => 'Home', 'method' => 'contact']);
// $router->addRoute('home/new-password', ['controller' => 'Home', 'method' => 'password']);

// add routes with variables for regular expression match
$router->addRoute('{controller}');
$router->addRoute('{controller}/{method}');

$router->dispatch($_SERVER['QUERY_STRING']);
