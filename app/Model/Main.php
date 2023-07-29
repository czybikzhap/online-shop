<?php

namespace App\Model;

use Model\ConnectFactory;

use PDO;

class Main
{
    private PDO $conn;

    public function __construct()
    {
        require_once "../Model/ConnectFactory.php";
        $this->conn = ConnectFactory::connectDB();
    }

    public function getProducts (): array
    {
        return $this->conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
    }

}