<?php

namespace App\Controller;

use App\Model\Main;

class MainController
{
    private Main $mainModel;

    public function __construct()
    {
        $this->mainModel = new Main();
    }


    public function main(): array
    {
        session_start();
        if (!isset($_SESSION['id'])) {
            header('Location :/login');
        }

        $products = $this->mainModel->getProducts();
        //print_r($products);

        return [
            'view' => 'main',
            'data' => [
                'products' => $products
            ]
        ];
    }

}

