<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location :/login');
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    //print_r($_POST);
    //echo '<br>';
    $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');
    $products = $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
    //print_r($products);

    $userId = $_SESSION['id'];
    //print_r($userId);
    //echo '<br>';
    $productId = $_POST['product_id'];
    //print_r($productId);


    $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');
    $dbBasketInfo = $conn->prepare("SELECT amount FROM basket WHERE user_id = :user_id AND 
                                product_id = :product_id");
    $dbBasketInfo->execute(['user_id' => $userId, 'product_id' => $productId]);
    $amount = $dbBasketInfo->fetch();
    print_r($amount);

    if (!isset($amount['amount'])) {
        $amount = 1;
        $stmt = $conn->prepare("INSERT INTO basket (user_id, product_id, amount) 
        VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    } else {
        $amount = $amount['amount'] + 1;
        $stmt = $conn->prepare("UPDATE basket SET amount = :amount WHERE user_id = :user_id AND
        product_id = :product_id");
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


