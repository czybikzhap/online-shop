<?php
$requestUri = $_SERVER["REQUEST_URI"];

if($requestUri === '/') {
        require_once './handlers/main.php';
    } elseif ($requestUri === '/signup') {
        require_once './handlers/signup.php';
    } elseif ($requestUri === '/login') {
        require_once './handlers/login.php';
    } elseif ($requestUri === '/main') {
        require_once './handlers/main.php';
    } elseif ($requestUri === '/addProduct') {
        require_once './handlers/addProduct.php';
    } elseif ($requestUri === '/logout') {
        require_once './handlers/logout.php';
    } else {
        require_once './views/notFound.html';
}


?>




