<?php


namespace Controllers;
use Lib\Pages;
use Lib\Utils;
use Models\Peticion;
use Models\Modelo;
use Models\Usuario;

class PeticionController{

    private Utils $utils;
    private Pages $pages;
    private Peticion $peticion;
    private Modelo $modelo;
    private Usuario $usuario;

    public function __construct(){
        $this -> utils = new Utils();
        $this -> pages = new Pages();
        $this -> peticion = new Peticion(0,0,0,0,0);
        $this -> usuario = new Usuario(0,'','','','','','','','','');
        $this -> modelo = new Modelo(0,'','','','','','','','','');


    }



    public function solicitud(){
        
        if($_SESSION['identity']->rol == 'ROLE_CREATOR'){


            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $datos = $_POST['data'];
                $file = $_FILES;

                $usuario = $this -> usuario -> buscaMail($_SESSION['identity']->email);

                $this -> peticion -> guardarPeticion($datos, $file, $usuario);

                $this -> pages -> render('usuario/profile');
    
            }
            else{
                $this -> pages -> render('usuario/profile');
            }
              
        
        }

    }


}


?>