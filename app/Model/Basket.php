<?php

namespace Model;

use PDO;

class Basket
{
    public function getBasket ()
    {
        $userId = $_SESSION['id'];
        echo $userId;

        require_once "../Model/ConnectDB.php";
        $connect = new ConnectDB();
        $conn = $connect->connectDB();

        $basket = $conn->prepare("SELECT * FROM baskets WHERE user_id = :user_id");
        $basket->execute(['user_id' => $userId]);
        return $basket->fetchAll(PDO::FETCH_ASSOC);
    }

}