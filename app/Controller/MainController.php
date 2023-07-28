<?php

namespace App\Controller;

use App\Model\Main;

class MainController
{

    public function main()
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location :/login');
        }

        $main = new Main(); //require_once "../Model/Main.php";
        $products = $main->getProducts();
        //print_r($products);

        require_once "../View/main.phtml";
    }

}

