<?php

namespace Model;

use PDO;

class Basket
{
    private PDO $conn;

    public function __construct()
    {
        require_once "../Model/ConnectDB.php";
        $this->conn = ConnectFactory::connectDB();
    }

    public function getBasket ()
    {
        $userId = $_SESSION['id'];
        echo $userId;

        $basket = $this->conn->prepare("SELECT * FROM baskets WHERE user_id = :user_id");
        $basket->execute(['user_id' => $userId]);
        return $basket->fetchAll(PDO::FETCH_ASSOC);
    }

    public function AddProducts(int $userId, int $productId): array|bool
    {
        $stmt = $this->conn->prepare("INSERT INTO baskets (user_id, product_id, amount)
            VALUES (:user_id, :product_id, 1)
            ON CONFLICT (user_id, product_id) 
            DO UPDATE SET amount = baskets.amount + EXCLUDED.amount");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

}