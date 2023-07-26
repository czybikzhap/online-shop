<?php

namespace Model;

use PDO;

class Main
{
    public function getProducts (): array
    {
        require_once "../Model/ConnectDB.php";
        $connect = new ConnectDB();
        $conn = $connect->connectDB();

        return $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
    }

}