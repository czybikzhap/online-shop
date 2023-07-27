<?php

use Model\User;

class UserController
{
    public function  login ()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $errors = $this->isValidLogin($_POST);

            if (empty($errors)) {
                require_once "../Model/User.php";


                $email = $_POST['email'];

                $user = new User();
                $dbinfo = $user->getUser($email);

                $password = $_POST['password'];

                if (!empty($dbinfo['email']) && (password_verify($password, $dbinfo['password']))) {
                    session_start();
                    $_SESSION['id'] = $dbinfo['id'];
                    header('Location:./main');
                } else {
                    $errors['password'] = 'неверное имя пользователя или пароль';
                }
            }
        }
        require_once '../View/login.phtml';
    }

    private function isValidLogin(array $data): array
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


    public function signup ()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $errors = $this->isValidSignUp($_POST);

            if (empty($errors)) {
                session_start();

                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                $hash = password_hash($password, PASSWORD_DEFAULT);

                require_once "../Model/User.php";
                $user = new User();
                $user->createUser($name, $email, $hash);

                header('Location: /login');
            }
        }
        require_once "../View/signup.phtml";
    }

    private function isValidSignUp(array $data): array
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

        if (!isset($data['email'])) {
            $errors['email'] = 'email is required';
        } else {
            $email = $data['email'];
            if (empty($email)) {
                $errors['email'] = 'email не может быть пустым';
            } elseif (strlen($email) < 2) {
                $errors['email'] = 'email должен содержать больше 2-х символов';
            } else {
                require_once "../Model/User.php";
                $user = new User();
                $userData = $user->getUser($email);

                if (!empty($userData['email'])) {
                    $errors['email'] = 'пользователь с таким адресом электронной почты уже зарегистрирован';
                }
            }
        }

        if (!isset($data['password'])) {
            $errors['password'] = 'password is required';
        } else {
            $password = $data['password'];
            if (empty($password)) {
                $errors['password'] = 'password не может быть пустым';
            } elseif (strlen($password) < 2) {
                $errors['password'] = 'password должен содержать больше 2-х символов';
            }
        }

        if (!isset($data['repeat_pwd'])) {
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



    public function logout ()
    {
        session_start();
        unset($_SESSION['user']);

    }


}