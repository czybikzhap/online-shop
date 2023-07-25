<?php

namespace Model;

Use PDO;

class User
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = new PDO('pgsql:host=db; dbname=dbname', 'dbuser', 'dbpwd');
    }

    public function create(array $data): array|false
    {
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];

        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

        return $stmt->fetch();
    }



}