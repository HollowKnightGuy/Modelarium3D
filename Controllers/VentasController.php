<?php

namespace Controllers;

use Models\Ventas;
use Lib\Pages;
use Lib\Utils;
use Controllers\InterController;

class VentasController
{


    private Pages $pages;
    private Ventas $ventas;
    private InterController $intercontroller;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->ventas = new Ventas("", "", "", "", "", "");
        $this->intercontroller = new InterController();
    }

    public function comprar($id){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["action"]) && $_POST["action"] == "buyNow") {

                if(Utils::isLogged()){
            
                    $id_modelo = $id;
                    $id_usuario_comprador = $_SESSION['identity']->id;
            
                    $modelo = $this -> intercontroller -> obtenerModeloPorId($id_modelo);
            
                    $this -> ventas -> comprar($modelo, $id_usuario_comprador);
            
                    return $this -> intercontroller -> mostrarModelo($id);
            
            
                }else{
                    Utils::irLogin();
                }

            }else{
                return $this -> intercontroller -> mostrarModelo($id);
            }

        }
          
    }

    public function comprobarVenta($id_modelo){

        if(Utils::isLogged()){

            $id_usuario = $_SESSION['identity']->id;
           return $this -> ventas -> comprobarVenta($id_usuario, $id_modelo);
        }else{
            Utils::irLogin();
        }
    }

    public function obtenerVentasUsuario($id_usuario_creador){
        return $this -> ventas -> obtenerVentasUsuario(($id_usuario_creador));
    }

    public function obtenerComprasUsuario($id_usuario){
        return $this -> ventas -> obtenerComprasUsuario(($id_usuario));
    }
}