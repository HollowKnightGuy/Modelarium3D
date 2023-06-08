<?php

namespace Controllers;

use Models\Ventas;
use Lib\Pages;
use Lib\Utils;

class VentasController
{


    private Pages $pages;
    private Ventas $ventas;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->ventas = new Ventas("", "", "", "", "", "");
    }

    public function comprar(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["action"]) && $_POST["action"] == "buyNow") {

                var_dump('skdaklsmf');die;
          }
        }
          
    }
}