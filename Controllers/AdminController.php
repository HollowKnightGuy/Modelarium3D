<?php


namespace Controllers;
use Lib\Pages;
use Controllers\UsuarioController;

class AdminController extends UsuarioController{


    public function __construct(){

    }


    public function solicitud(){



        if($_SESSION['admin'] == TRUE){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $datos = $_POST['data'];
                $this -> pages -> render('admin/managerequest');
    
            }
            else{
                $this -> pages -> render('admin/requests');
            }
              
        }
        
        elseif($_SESSION['rol'] == 'ROLE_CREATOR'){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $datos = $_POST['data'];
                $this -> pages -> render('creator/request');
    
            }
            else{
                $this -> pages -> render('creator/request');
            }
              
        
        }

    }


    public function gestionUsuarios(){

        if($_SESSION['admin'] == TRUE){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $datos = $_POST['data'];
                $this -> pages -> render('admin/users');

            }
            else{
                $this -> pages -> render('admin/users');
            }
              
        }
    }

}


?>

