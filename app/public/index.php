<?php
$requestUri = $_SERVER["REQUEST_URI"];

if($requestUri === '/') {
    require_once '../Controller/MainController.php';
    $object = new MainController();
    $object->main();
} elseif ($requestUri === '/signup') {
    require_once '../Controller/UserController.php';
    $object = new UserController();
    $object->signup();
} elseif ($requestUri === '/login') {
    require_once '../Controller/UserController.php';
    $object = new UserController();
    $object->login();
} elseif ($requestUri === '/main') {
    require_once '../Controller/MainController.php';
    $object = new MainController();
    $object->main();
} elseif ($requestUri === '/basket') {
    require_once '../Controller/BasketController.php';
    $object = new BasketController();
    $object->basket();
}elseif ($requestUri === '/addProduct') {
    require_once '../Controller/BasketController.php';
    $object = new BasketController();
    $object->addProducts();
} elseif ($requestUri === '/logout') {
    require_once '../Controller/UserController.php';
    $object = new UserController();
    $object->logout();
} else {
    require_once '../View/notFound.html';
}

/*
if($requestUri === '/') {
        require_once './handlers/main.php';
    } elseif ($requestUri === '/signup') {
        require_once './handlers/signup.php';
    } elseif ($requestUri === '/login') {
        require_once './handlers/login.php';
    } elseif ($requestUri === '/main') {
        require_once './handlers/main.php';
    } elseif ($requestUri === '/basket') {
        require_once './handlers/basket.php';
    }elseif ($requestUri === '/addProduct') {
        require_once './handlers/addProduct.php';
    } elseif ($requestUri === '/logout') {
        require_once './handlers/logout.php';
    } else {
        require_once './views/notFound.html';
}
*/






