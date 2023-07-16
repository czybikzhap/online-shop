<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location :/login');
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    print_r($_POST);
    $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');
    $products = $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
    //print_r($products);

    $userId = $_SESSION['id'];
    //print_r($userId);
    $productId = $_POST['product_id'];
    $amount = 1;

    $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');
    $dbBasketInfo = $conn->query("SELECT * FROM basket")->fetchAll(PDO::FETCH_ASSOC);

    print_r($dbBasketInfo);
    if ($dbBasketInfo) {
        $amount = $amount + 1;
        $stmt = $conn->prepare("UPDATE basket SET amount = :amount WHERE user_id = :user_id AND
        product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    } else {
        $stmt = $conn->prepare("INSERT INTO basket (user_id, product_id, amount) 
        VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }








    //$stmt = $conn->prepare("INSERT INTO basket (user_id, product_id, amount)
    //VALUES (:user_id, :product_id, :amount)
    //ON CONFLICT (user_id, product_id) DO UPDATE SET amount = :amount + 1 ");
    //$stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);

    //$basket = $conn->query("SELECT * FROM basket ")->fetchAll(PDO::FETCH_ASSOC);

    //print_r($basket);


//require_once './handlers/main.php';
}


