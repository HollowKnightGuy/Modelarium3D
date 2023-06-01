<?php


namespace Controllers;
use Lib\Pages;
use Models\Usuario;


class UsuarioController{


    private Pages $pages;
    private Usuario $usuario;

    public function __construct(){

        $this -> pages = new Pages();
        $this -> usuario = new Usuario(0,'','','','','','','','','');     

    }


    //Llama al método register de  y muestra la vista de registro
    public function registro(){
        $_SESSION['scripts'] = ['main', 'psmain'];
        $_SESSION['header'] = "";
        $message = ["generico" => "", "password" => "", "email" => "", "nombre" => "", "descripcion" => "", "imagen" => ""];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            if($_POST['data']){
                $registrado = $_POST['data'];
                $registrado['file'] = $_FILES['file'];
                list($ancho, $alto) = getimagesize( $registrado['file']['tmp_name']);
                $peso = $_FILES['file']['size'] / 1024;
                $propiedadesImg = ['ancho' => $ancho, 'alto' => $alto, 'tipo' => explode("/", $registrado['file']['type'])[1], 'peso' => $peso];
                $usuario = Usuario::fromArray($registrado);
            }
            $save = $usuario -> save($message, $propiedadesImg);
            var_dump($save);
            if($save === true){
                $this -> login(true);
            }else if(gettype($save) === "string"){
                $this -> pages -> render('usuario/registerform', ['message' => $save, 'datos_guardados' => $_POST['data'], 'imagenval' => $_FILES]);
            }else{
                $message['generico'] = 'No se ha podido registrar al usuario';
                $this -> pages -> render('usuario/registerform', ['message' => $save, 'datos_guardados' => $_POST['data'], 'imagenval' => $_FILES]);
            }
        }else{
            $this -> pages -> render('usuario/registerform', ['message' => $message, 'datos_guardados' => []]);
        }
    }




    public function login($registro = false){
        $_SESSION['scripts'] = ['main', 'psmain'];
        $_SESSION['header'] = "";
        if($_SERVER['REQUEST_METHOD'] === 'POST' || $registro){

            if($_POST['data']){
                $auth = $_POST['data'];
                $usuario = Usuario::fromArray($auth);
                $identity = $usuario -> login();

                if($identity && is_object($identity)){
                    $_SESSION['identity'] = $identity;
                    if($identity -> rol == 'ROLE_ADMIN'){
                        $_SESSION['admin'] = true;
                    }
                    $this -> pages -> render("modelos/models");
                    $_SESSION['error_login'] = '';

                }else{
                    $_SESSION['error_login'] = 'Identificación fallida !!';

                    $this -> pages -> render('usuario/loginform');
                }
            }
        } else{
            $_SESSION['error_login'] = '';
            $this -> pages -> render('usuario/loginform');
        }
    }
    

    //Cierra la sesión del usuario y le devuelve a la vista principal
    public function cerrar_sesion(){
        unset($_SESSION['admin']);
        unset($_SESSION['identity']);
        $_SESSION['header'] = "";
        $this -> pages -> render("modelos/models");

    }

    public function obtenerUsuario($mail){
        return $this->usuario->buscaMail($mail);
    }

    public function update(){
        var_dump('nknsa');
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $datos = $_POST['data'];
                       
            
            $this -> pages -> render('usuario/profile');

        }
        else{
            $this -> pages -> render('usuario/profile');
        }
    }

    
    public function perfil(){
        
        $_SESSION['header'] = "";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $datos = $_POST['data'];
                       
            
            $this -> pages -> render('usuario/profile');

        }
        else{
            $this -> pages -> render('usuario/profile');
        }

    }

    public function autor(){
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $datos = $_POST['data'];
                       
            
            $this -> pages -> render('usuario/author');

        }
        else{
            $this -> pages -> render('usuario/author');

        }
        $_SESSION['header'] = "";

    }

    
    public function perfilajustes(){
        
        $_SESSION['scripts'] = ['psmain'];
        $_SESSION['header'] = "";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $datos = $_POST['data'];
            $this -> pages -> render('usuario/profilesettings');

        }
        else{
            $this -> pages -> render('usuario/profilesettings');
        }

    }


    public function sercreador(){
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $datos = $_POST['data'];
            $this -> pages -> render('usuario/creatorform');

        }
        else{
            $this -> pages -> render('usuario/creatorform');
        }
        $_SESSION['header'] = "";

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
            $_SESSION['header'] = ""; 
        }
        
        elseif($_SESSION['rol'] == 'ROLE_CREATOR'){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $datos = $_POST['data'];
                $this -> pages -> render('creator/request');
    
            }
            else{
                $this -> pages -> render('creator/request');
            }
            $_SESSION['header'] = ""; 
        
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
            $_SESSION['header'] = ""; 
        }
    }

}


?>

