<?php

namespace App\Controller;

use App\Model\Basket;

class BasketController
{
    private Basket $basketModel;

    public function __construct()
    {
        $this->basketModel = new Basket();
    }

    public function basket(): void
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location :/login');
        }

        $basket = $this->basketModel->getBasket();

        require_once "../View/baskets.phtml";
    }

    public function addProducts(): void
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location :/login');
        } else {
            header("Location: /main");
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $errors = $this->isValidAddProduct($_POST);

            if(empty($errors)) {

                $userId = $_SESSION['id'];
                $productId = $_POST['product_id'];

                $this->basketModel->AddProducts($userId, $productId);

            }

//            require_once "../View/main.phtml";
        }
    }

    private function isValidAddProduct(array $data): array
    {
        $errors = [];
        if (!isset($data['product_id'])) {
            $errors['product_id'] = 'product_id is required';
        } else {
            $productId = $data['product_id'];
            if (empty($productId)) {
                $errors['product_id'] = 'product_id не может быть пустым';
            }
        }
        return $errors;
    }
}