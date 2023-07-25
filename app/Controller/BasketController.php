<?php

class BasketController
{
    public function basket()
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location :/login');
        }

        $userId = $_SESSION['id'];

        $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');
        $basket = $conn->prepare("SELECT * FROM baskets WHERE user_id = :user_id");
        $basket->execute(['user_id' => $userId]);
        $basket = $basket->fetchAll();
        //print_r($basket);
        echo '<br>';
        $products = $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
        //print_r($products);
        require_once "../View/baskets.phtml";
    }

    public function addProducts()
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location :/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            //print_r($_POST);
            //echo '<br>';
            $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');

            $userId = $_SESSION['id'];
            //print_r($userId);
            //echo '<br>';
            $productId = $_POST['product_id'];
            //print_r($productId);

            $stmt = $conn->prepare("INSERT INTO baskets (user_id, product_id, amount)
                VALUES (:user_id, :product_id, 1)
                ON CONFLICT (user_id, product_id) DO UPDATE SET amount = baskets.amount + EXCLUDED.amount");
            $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);

            require_once '../Controller/MainController.php';
            $object = new MainController();
            $object->main();
        }
    }
}


