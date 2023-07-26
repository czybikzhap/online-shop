<?php

use Model\Main;

class MainController
{

    public function main()
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location :/login');
        }

        require_once "../Model/Main.php";
        $main = new Main();
        $products = $main->getProducts();


        require_once "../View/main.phtml";
    }

}

