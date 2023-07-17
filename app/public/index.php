<?php
$requestUri = $_SERVER["REQUEST_URI"];
/*
if($requestUri === '/') {
    $object = new UserController();
    $object->main();
} elseif ($requestUri === '/signup') {
    $object = new UserController();
    $object->signup();
} elseif ($requestUri === '/login') {
    $object = new UserController();
    $object->login();
} elseif ($requestUri === '/main') {
    $object = new UserController();
    $object->main();
} elseif ($requestUri === '/basket') {
    $object = new UserController();
    $object->basket();
}elseif ($requestUri === '/addProduct') {
    $object = new UserController();
    $object->addProducts();
} elseif ($requestUri === '/logout') {
    $object = new UserController();
    $object->logout();
} else {
    require_once '../View/notFound.html';
}
*/
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







