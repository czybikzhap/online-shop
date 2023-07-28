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
        require_once "../Model/ConnectFactory.php";
        $conn = ConnectFactory::connectDB();

        return $this->conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
    }

}