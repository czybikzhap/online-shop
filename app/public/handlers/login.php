<?php
function isValidLogin(array $data, PDO $conn): array
{
    $errors = [];
    if (!isset($data['email'])) {
        $errors['email'] = 'email is required';
    }
    $email = $data['email'];
    if (empty($email)){
        $errors['email'] = 'email не может быть пустым';
    }
    if (!isset($data['password'])){
        $errors['password'] = 'password is required';
    }
    $password = $data['password'];
    if (empty($password)){
        $errors['password'] = 'password не может быть пустым';
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $dbinfo = $stmt->fetch();
    $hash = $dbinfo['password'];

    if (!$dbinfo['email']) {
        $errors['password'] = 'неверное имя пользователя или пароль';
    }

    if (!password_verify($data['password'], $hash)) {
        $errors['password'] = 'неверное имя пользователя или пароль';
    }
    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $conn = new PDO('pgsql:host=db; dbname=dbname', 'dbuser', 'dbpwd');

    $errors = isValidLogin($_POST, $conn);
    $user = 1;
    session_start();
    print_r($_SESSION['id'] = $user);

}
require_once './views/login.html';