<?php
$requestUri = $_SERVER["REQUEST_URI"];

if($requestUri === '/') {
    require_once './views/main.html';
    } elseif ($requestUri === '/signup') {
        require_once './handlers/signup.php';
    } elseif ($requestUri === '/login') {
        require_once './handlers/login.php';
    } elseif ($requestUri === '/main') {
        session_start();
        require_once './views/main.html';
        //echo $_SESSION['id'];
    } else {
        require_once './views/notFound.html';

}


?>




