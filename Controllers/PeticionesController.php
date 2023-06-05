<?php


namespace Controllers;
use Lib\Pages;
use Lib\Utils;
use Models\Peticiones;

class PeticionesController{

    private Utils $utils;
    private Pages $pages;
    private Peticion $peticiones;

    public function __construct(){
        $this -> utils = new Utils();
        $this -> pages = new Pages();
        $this -> peticiones = new Peticiones();

    }



    public function solicitud(){


        if(Utils::isAdmin()){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $datos = $_POST['data'];
                $this -> pages -> render('admin/managerequest');
    
            }
            else{
                $this -> pages -> render('admin/requests');
            }
              
        }
        
        elseif($_SESSION['identity']->rol == 'ROLE_CREATOR'){


            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $datos = $_POST['data'];
                var_dump($datos, $_FILES); die;

                $this -> pages -> render('usuario/profile');
    
            }
            else{
                $this -> pages -> render('usuario/profile');
            }
              
        
        }

    }

}


?>