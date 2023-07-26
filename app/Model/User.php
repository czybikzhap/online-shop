<?php

namespace Model;

class User
{
    public function createUser(): array|false
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $password = password_hash($password, PASSWORD_DEFAULT);
        require_once "../Model/ConnectDB.php";
        $connect = new ConnectDB();
        $conn = $connect->connectDB();

        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

        return $stmt->fetch();
    }

    public function getUser(): array|false
    {
        require_once "../Model/ConnectDB.php";

        $connect = new ConnectDB();
        $conn = $connect->connectDB();

        $email = $_POST['email'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email ");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

}