<?php

class MainController
{

    public function main()
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location :/login');
        }

        $conn = new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');
        $products = $conn->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);

        require_once "./views/main.phtml";
    }

}

