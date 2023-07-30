<?php

namespace App\Model;

use Model\ConnectFactory;

use PDO;

class User
{
    private static string $id;
    private string $name;
    private string $email;
    private string $hash;

    private PDO $conn;

    public function __construct(string $name, string $email, string $hash)
    {
        $this->name = $name;
        $this->email = $email;
        $this->hash = $hash;

        require_once "../Model/ConnectFactory.php";
        $this->conn = ConnectFactory::connectDB();
    }

    public function createUser(): array|false
    {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password) 
            VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $this->name, 'email' => $this->email, 'password' => $this->hash]);

        return $stmt->fetch();
    }

    public static function getUser(string $email): User|null
    {
        require_once "../Model/ConnectFactory.php";

        $stmt = ConnectFactory::connectDB()->prepare("SELECT * FROM users WHERE email = :email ");
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();

        self::$id = $data['id'];

        if (!$data) {
            return null;
        }

        $user = new User($data['name'], $data['email'], $data['password']);

        return $user;
    }

    public function getPassword(): string
    {
        return $this->hash;
    }

    public function getUserId(): string
    {
        return self::$id;
    }

}