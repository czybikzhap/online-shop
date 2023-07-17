<?php

class UserController
{
    public function  login ()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $conn = new PDO('pgsql:host=db; dbname=dbname', 'dbuser', 'dbpwd');

            $email = $_POST['email'];
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $dbinfo = $stmt->fetch();
            $hash = $_POST['password'];

            $errors = isValidLogin($_POST, $conn);
            if (!empty($dbinfo['email']) && !(password_verify($dbinfo['password'], $hash))) {
                session_start();
                $_SESSION['id'] = $dbinfo['id'];
                //setcookie('user', $dbinfo['email'], time() + 3600); //авторизация с помощью куки
                header('Location:./main');

            } else {
                $errors['password'] = 'неверное имя пользователя или пароль';
            }

        }

//if (isset($_COOKIE['user'])) {
        // header('Location: /main');
//}
        require_once '../View/login.phtml';
        function isValidLogin(array $data, PDO $conn): array
        {
            $errors = [];
            if (!isset($data['email'])) {
                $errors['email'] = 'email is required';
            } else {
                $email = $data['email'];
                if (empty($email)) {
                    $errors['email'] = 'email не может быть пустым';
                }
            }
            if (!isset($data['password'])){
                $errors['password'] = 'password is required';
            } else {
                $password = $data['password'];
                if (empty($password)) {
                    $errors['password'] = 'password не может быть пустым';
                }
            }

            return $errors;
        }

    }

    public function signup ()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $conn = new PDO('pgsql:host=db; dbname=dbname', 'dbuser', 'dbpwd');

            $errors = isValidSignUp($_POST, $conn);

            if (empty($errors)) {
                session_start();
                header('Location: /login');

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

        require_once "../View/signup.phtml";
        function isValidSignUp(array $data, PDO $conn): array
        {
            $errors = [];

            if (!isset($data['name'])) {
                $errors['name'] = 'name is required';
            } else {
                $name = $data['name'];
                if (empty($name)) {
                    $errors['name'] = 'name не может быть пустым';
                } elseif (strlen($name) < 2) {
                    $errors['name'] = 'name должен содержать больше 2-х символов';
                }
            }


            if (!isset($data['email'])){
                $errors['email'] = 'email is required';
            } else {
                $email = $data['email'];
                if (empty($email)){
                    $errors['email'] = 'email не может быть пустым';
                } elseif (strlen($email) < 2) {
                    $errors['email'] = 'email должен содержать больше 2-х символов';
                } else {
                    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email ");
                    $stmt->execute(['email' => $email]);
                    $userData = $stmt->fetch();
                    if (!empty($userData['email'])) {
                        $errors['email'] = 'пользователь с таким адресом электронной почты уже зарегистрирован';
                    }
                }
            }

            if (!isset($data['password'])){
                $errors['password'] = 'password is required';
            } else {
                $password = $data['password'];
                if (empty($password)) {
                    $errors['password'] = 'password не может быть пустым';
                } elseif (strlen($password) < 2) {
                    $errors['password'] = 'password должен содержать больше 2-х символов';
                }
            }

            if (!isset($data['repeat_pwd'])){
                $errors['repeat_pwd'] = 'password is required';
            } else {
                $repeat_pwd = $data['repeat_pwd'];
                if (empty($repeat_pwd)) {
                    $errors['repeat_pwd'] = 'password не может быть пустым';
                } elseif ($repeat_pwd !== $data['password']) {
                    $errors['repeat_pwd'] = 'пароли не совадают';
                }
            }
            return $errors;
        }
    }

    public function main ()
    {
        if (!isset($_SESSION['id'])) {
            header('Location :/login');
        }
//print_r($_SESSION['id']);

//print_r($_COOKIE['user']);
        $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');
        $products = $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
        print_r($products);

        require_once "../View/main.phtml";
    }

    public function basket ()
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location :/login');
        }

        $userId = $_SESSION['id'];

        $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');
        $basket = $conn->prepare("SELECT * FROM baskets WHERE user_id = :user_id");
        $basket->execute(['user_id' => $userId]);
        $basket = $basket->fetchAll();
        print_r($basket);
        echo '<br>';



        require_once "../View/baskets.phtml";
    }

    public function addProducts ()
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location :/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            //print_r($_POST);
            //echo '<br>';
            $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');
            $products = $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
            print_r($products);

            $userId = $_SESSION['id'];
            //print_r($userId);
            //echo '<br>';
            $productId = $_POST['product_id'];
            //print_r($productId);
            $amount = 1;

            $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');
            $basket = $conn->prepare("SELECT * FROM baskets WHERE user_id = :user_id AND product_id = :product_id");
            $basket->execute(['user_id' => $userId, 'product_id' => $productId]);
            $basket = $basket->fetch();
            $quantity = $basket['amount'];
            print_r($quantity);

            $stmt = $conn->prepare("INSERT INTO baskets (user_id, product_id, amount)
        VALUES (:user_id, :product_id, :amount)
        ON CONFLICT (user_id, product_id) DO UPDATE SET amount = :amount + EXCLUDED.amount");
            $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $quantity]);


            /*
            $dbBasketInfo = $conn->prepare("SELECT amount FROM basket WHERE user_id = :user_id AND
                                        product_id = :product_id");
            $dbBasketInfo->execute(['user_id' => $userId, 'product_id' => $productId]);
            $amount = $dbBasketInfo->fetch();
            print_r($amount);

            if (!isset($amount['amount'])) {
                $amount = 1;
                $stmt = $conn->prepare("INSERT INTO basket (user_id, product_id, amount)
                VALUES (:user_id, :product_id, :amount)");
                $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
            } else {
                $amount = $amount['amount'] + 1;
                $stmt = $conn->prepare("UPDATE basket SET amount = :amount WHERE user_id = :user_id AND
                product_id = :product_id");
                $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
            }
        */

            require_once './handlers/main.php';
        }
    }

    public function logout ()
    {
        session_start();
        unset($_SESSION['user']);

//unset($_COOKIE['user']);
//setcookie('user', null, time() - 3600);
//header('Location: /login');
    }


}