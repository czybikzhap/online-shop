<?php
$requestUri = $_SERVER["REQUEST_URI"];

if($requestUri === '/signup') {
        require_once './handlers/signup.php';
    } elseif ($requestUri === '/login') {
        require_once './handlers/login.php';
    } elseif ($requestUri === '/main') {
        session_start();
        echo $_SESSION['id'];

    } else {
        echo 'not found';
}



?>




