<?php


namespace Controllers;
use Lib\Pages;
use Lib\Utils;
use Models\Peticion;
use Controllers\UsuarioController;
use Controllers\ModeloController;
class PeticionController{

    private Utils $utils;
    private Pages $pages;
    private Peticion $peticion;
    private UsuarioController $ucontroller;
    private ModeloController $mcontroller;

    public function __construct(){
        $this -> utils = new Utils();
        $this -> pages = new Pages();
        $this -> peticion = new Peticion(0,0,0,0,0);
        $this -> ucontroller = new UsuarioController();
        $this -> mcontroller = new ModeloController();
    }



    public function solicitud(){

        //TODO HACER QUE NO HAGAN FALTA LOS CONTROLADORES; POR EJEMPLO PASAR EL OBJETO USUARIO A ESTA FUNCIÓN EN LUGAR DE USAR EL CONTROLADOR
        
        if($_SESSION['identity']->rol == 'ROLE_CREATOR'){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
		        $message = ['titulo' => "", 'precio' => "", 'descripcion_modelo' => "", 'modelo_glb' => "", 'modelo_foto' => ""];
                $datos = $_POST['data'];
                $file = $_FILES;
                $usuario = $this -> ucontroller -> obtenerUsuario($_SESSION['identity']->email);

                $peticion = $this -> peticion -> guardarPeticionModelo($message, $datos, $file, $usuario);
                if( $peticion === true){
                    $this -> pages -> render('usuario/profile', ['message' => $message]);
                }else if(gettype($peticion) === "array" ){
                    $this -> pages -> render('modelos/create_edit_model', ['message' => $peticion]);
                }else{
                    $this -> pages -> render('usuario/profile');
                }
            }
            else{
                $this -> pages -> render('usuario/profile');
            }
              
        
        }

        elseif(Utils::isAdmin()){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){    
            }
            else{
                $this -> pages -> render('admin/requests');
            }
              
        
        }

    }

    // public function obtenerModelo($id_usuario, $titulo){
    //     $this -> mcontroller -> obtenerModelo($id_usuario, $titulo);
    // }


}


?>