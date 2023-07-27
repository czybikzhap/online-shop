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

    public function AddProducts(): array|bool
    {

        require_once "../Model/ConnectDB.php";
        $connect = new ConnectDB();
        $conn = $connect->connectDB();

        $userId = $_SESSION['id'];
        $productId = $_POST['product_id'];

        $stmt = $conn->prepare("INSERT INTO baskets (user_id, product_id, amount)
            VALUES (:user_id, :product_id, 1)
            ON CONFLICT (user_id, product_id) DO UPDATE SET amount = baskets.amount + EXCLUDED.amount");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

}