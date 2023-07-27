<?php

namespace Model;

use PDO;

class User
{
    private PDO $conn;

    public function __construct()
    {
        require_once "../Model/ConnectDB.php";
        $this->conn = ConnectFactory::connectDB();
    }

    public function createUser(string $name, string $email, string $hash): array|false
    {
        $stmt= $this->conn->prepare("INSERT INTO users (name, email, password) 
            VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);

        return $stmt->fetch();
    }

    public function getUser(string $email): array|false
    {
        require_once "../Model/ConnectDB.php";

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email ");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

}