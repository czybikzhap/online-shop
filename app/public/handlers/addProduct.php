<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location :/login');
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    print_r($_POST);
    $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');
    $products = $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);

    $user_id =  $_SESSION['id']['id']; print_r($user_id);
    $product_id = $_POST['product_id'];
    $amount = 1;

    $stmt = $conn->prepare("INSERT INTO basket (user_id, product_id, amount) 
    VALUES (:user_id, :product_id, :amount) 
    ON CONFLICT (user_id, product_id) DO UPDATE SET amount = :amount + 1 ");
    $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);

    $basket = $conn->query("SELECT * FROM basket ")->fetchAll(PDO::FETCH_ASSOC);

    print_r($basket);


}

