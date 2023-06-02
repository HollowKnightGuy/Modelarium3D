<?php


namespace Controllers;
use Lib\Pages;
use Lib\Utils;
use Models\Usuario;

class UsuarioController{

    private Utils $utils;
    private Pages $pages;
    private Usuario $usuario;

    public function __construct(){
        $this -> utils = new Utils();
        $this -> pages = new Pages();
        $this -> usuario = new Usuario(0,'','','','','','','','','');     

    }


    //Llama al método register de  y muestra la vista de registro
    public function registro(){
         
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
            if($save === true){
                if(Utils::isAdmin()){
                    $this -> pages -> render('admin/users', ['usuarios' => $this -> usuario -> getall()]);
                }else{
                    $this -> login(true);
                }
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
         
        $message = ["generico" => "", "password" => "", "email" => ""];

        if($_SERVER['REQUEST_METHOD'] === 'POST' || $registro){

            if($_POST['data']){
                $auth = $_POST['data'];
                $usuario = Usuario::fromArray($auth);
                $identity = $usuario -> login($message);
                if(gettype($identity) == "array"){
                    $this -> pages -> render('usuario/loginform', ["message" => $identity, "datos_guardados" => $auth]);
                }
                else if($identity && is_object($identity)){
                    $_SESSION['identity'] = $identity;
                    if($identity -> rol == 'ROLE_ADMIN'){
                        $_SESSION['admin'] = true;
                    }
                    $this -> pages -> render("modelos/models");
                }
            }
        } else{
            $this -> pages -> render('usuario/loginform', ['message' => $message, 'datos_guardados' => []]);
        }
    }
    

    //Cierra la sesión del usuario y le devuelve a la vista principal
    public function cerrar_sesion(){
        unset($_SESSION['admin']);
        unset($_SESSION['identity']);
         
        $this -> pages -> render("modelos/models");
    }

    public function obtenerUsuario($mail){
        return $this->usuario->buscaMail($mail);
    }

    public function update(){
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $datos = $_POST['data'];
            $img = $_FILES;
            
            $this -> usuario -> update($datos, $img);
            $this -> pages -> render('usuario/profilesettings');

        }
        else{
            $this -> pages -> render('usuario/profilesettings');
        }
    }

    
    public function perfil(){
        
         
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
         

    }

    
    public function perfilajustes(){
        
        $_SESSION['scripts'] = ['psmain'];
         
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

        if(Utils::isAdmin()){
            $usuarios = $this -> usuario -> getall();
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $datos = $_POST['data'];
                $this -> pages -> render('admin/users');

            }
            $this -> pages -> render('admin/users', ['usuarios' => $usuarios]);  
        }else{
            $this -> pages -> render('/');
        }
    }

    public function borrarUsuario($id){
        if(Utils::isAdmin()){
            $borrar = $this -> usuario -> borrar($id);
            if($borrar){
                return true;
            }else{
                return $borrar;
            }
        }else{
            $this -> pages -> render('/');
        }
    }

}


?>

