<?php
$requestUri = $_SERVER["REQUEST_URI"];

if($requestUri === '/signup') {
    function isValidSignUp(array $data, PDO $conn): array
    {
        $errors = [];

        if (isset($name)) {
            $errors['name'] = 'name is required';
        }
        $name = $data['name'];
        if (empty($name)){
            $errors['name'] = 'email не может быть пустым';
        }
        if (strlen($name) < 2) {
            $errors['name'] = 'name должен содержать больше 2-х символов';
        }

        if (isset($email)){
            $errors['email'] = 'email is required';
        }
        $email = $data['email'];
        if (empty($email)){
            $errors['email'] = 'email не может быть пустым';
        }
        if (strlen($email) < 2){
            $errors['email'] = 'email должен содержать больше 2-х символов';
        }

        if (isset($password)){
            $errors['password'] = 'password is required';
        }
        $password = $data['password'];
        if (empty($password)){
            $errors['password'] = 'password не может быть пустым';
        }
        if (strlen($password) < 2){
            $errors['password'] = 'password должен содержать больше 2-х символов';
        }
        if (isset($repeat_pwd)){
            $errors['repeat_pwd'] = 'password is required';
        }
        $repeat_pwd = $data['repeat_pwd'];
        if (empty($repeat_pwd)){
            $errors['repeat_pwd'] = 'password не может быть пустым';
        }
        if ($password !== $repeat_pwd){
            $errors['repeat_pwd'] = 'пароли не совадают';
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email ");
        $stmt->execute(['email' => $email]);
        $userData = $stmt->fetch();
        if (!empty($userData)) {
            $errors['email'] = 'пользователь с таким адресом электронной почты уже зарегистрирован';
        }
        return $errors;
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $conn = new PDO('pgsql:host=db; dbname=dbname', 'dbuser', 'dbpwd');
        $errors = isValidSignUp($_POST, $conn);

        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $repeat_pwd = $_POST['repeat_pwd'];

            $password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

            $stmt = $conn->prepare("SELECT * FROM users WHERE name = :name");
            $stmt->execute(['name' => $name]);
            $dbinfo = $stmt->fetch();

            print_r('id - ' . $dbinfo['id']);
            echo '<br>';
            print_r('name - ' . $dbinfo['name']);
            echo '<br>';
            print_r('email - ' . $dbinfo['email']);
            echo '<br>';
            print_r('password - ' . $dbinfo['password']);
        }

    }

    require_once './views/signup.html';

} elseif ($requestUri === '/login') {
  function isValidLogin(array $data, PDO $conn): array {

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

        if (empty($dbinfo['email']) or !password_verify($data['password'], $hash)) {
            $errors['email'] = 'неверное имя пользователя или пароль';
        }
        return $errors;
    }
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $conn = new PDO('pgsql:host=db; dbname=dbname', 'dbuser', 'dbpwd');

        $errors = isValidLogin($_POST, $conn);
        $user = 1;
        session_start();
        $_SESSION['id'] = $user;


    }


} elseif ($requestUri === '/main') {
    session_start();
    echo $_SESSION['id'];

} else {
echo 'not found';
}



?>




