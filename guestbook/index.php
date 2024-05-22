<?php
// TODO 1: PREPARING ENVIRONMENT: 1) session 2) functions

// 1. namespace
namespace guestbook;
define('__ROOT__', dirname(dirname(__FILE__)));

session_start();

// 2. use

// 3. require_once
require_once 'vendor/autoload.php';

require_once 'Controllers/HomeController.php';
require_once 'Controllers/RegisterController.php';
require_once 'Controllers/LoginController.php';
require_once 'Controllers/AdminController.php';
require_once 'Controllers/LogoutController.php';
require_once 'Controllers/GuestbookController.php';

// TODO 2: ROUTING
switch ($_SERVER['REQUEST_URI']) {
    case '/':
        dump($_SERVER['REQUEST_URI']);
        $controllerClassName = 'HomeController';
        break;
    case '/register':
        dump($_SERVER['REQUEST_URI']);
        $controllerClassName = 'RegisterController';
        break;
    case '/login':
        dump($_SERVER['REQUEST_URI']);
        $controllerClassName = 'LoginController';
        break;
    case '/logout':
        dump($_SERVER['REQUEST_URI']);
        $controllerClassName = 'LogoutController';
        break;
    case '/admin':
        dump($_SERVER['REQUEST_URI']);
        $controllerClassName = 'AdminController';
        break;
    case '/guestbook':
        dump($_SERVER['REQUEST_URI']);
        $controllerClassName = 'GuestbookController';
        break;
    default:
        dump($_SERVER['REQUEST_URI']);
        die;
}

$controllerClassName = "guestbook\Controllers\\$controllerClassName";
$controller = new $controllerClassName();
$controller->execute();