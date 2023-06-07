<?php


namespace Controllers;

use Lib\Pages;
use Lib\Utils;
use Models\Usuario;


class UsuarioController
{

    private Utils $utils;
    private Pages $pages;
    private Usuario $usuario;


    public function __construct()
    {
        $this->utils = new Utils();
        $this->pages = new Pages();
        $this->usuario = new Usuario(0, '', '', '', '', '', '', '', '', '');
    }


    //Llama al método register de  y muestra la vista de registro
    public function registro()
    {
        if(!Utils::isLogged() || Utils::isAdmin()){
            $message = ["generico" => "", "password" => "", "email" => "", "nombre" => "", "descripcion" => "", "imagen" => ""];
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
                if ($_POST['data']) {
                    $registrado = $_POST['data'];
                    $registrado['file'] = $_FILES['file'];
                    $usuario = Usuario::fromArray($registrado);
                }
                $save = $usuario->save($message);
                if ($save === true) {
                    if (Utils::isAdmin()) {
                        $this->pages->render('admin/users', ['usuarios' => $this->usuario->getall()]);
                    } else {
                        $this->login(true);
                    }
                } else if (gettype($save) === "string") {
                    $this->pages->render('usuario/registerform', ['message' => $save, 'datos_guardados' => $_POST['data'], 'imagenval' => $_FILES]);
                } else {
                    $message['generico'] = 'No se ha podido registrar al usuario';
                    $this->pages->render('usuario/registerform', ['message' => $save, 'datos_guardados' => $_POST['data'], 'imagenval' => $_FILES]);
                }
            } else {
                $this->pages->render('usuario/registerform', ['message' => $message, 'datos_guardados' => []]);
            }
        }else{
            Utils::irModels();
        }
    }




    public function login($registro = false)
    {
        if(!Utils::isLogged()){            
            $message = ["generico" => "", "password" => "", "email" => ""];
    
            if ($_SERVER['REQUEST_METHOD'] === 'POST' || $registro) {
    
                if ($_POST['data']) {
                    $auth = $_POST['data'];
                    $usuario = Usuario::fromArray($auth);
                    $identity = $usuario->login($message);
                    if (gettype($identity) == "array") {
                        $this->pages->render('usuario/loginform', ["message" => $identity, "datos_guardados" => $auth]);
                    } else if ($identity && is_object($identity)) {
                        $_SESSION['identity'] = $identity;
                        if ($identity->rol == 'ROLE_ADMIN') {
                            $_SESSION['admin'] = true;
                        }
                        Utils::irModels();
                    }
                }
            } else {
                $this->pages->render('usuario/loginform', ['message' => $message, 'datos_guardados' => []]);
            }
        }else{
            Utils::irModels();
        }
    }


    //Cierra la sesión del usuario y le devuelve a la vista principal
    public function cerrar_sesion()
    {
        unset($_SESSION['admin']);
        unset($_SESSION['identity']);

        Utils::irModels();
    }

    public function obtenerUsuario($mail)
    {
        return $this->usuario->buscaMail($mail);
    }

    public function obtenerUsuarioPorId($id)
    {
        return $this->usuario->buscaId($id);
    }


    public function update($id = null, $adminview = false)
    {
        if(Utils::isLogged()){
            $message = ["nombre" => "", "descripcion" => "", "imagen" => "", "imagenbanner" => ""];
            if ($id != null) {
                $this->pages->render('usuario/edit_user', ['message' => $message, 'datos_guardados' => "", 'id' => $id]);
            } else {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $datos = $_POST['data'];
                    $img = $_FILES;
                    $imgProps = ['profile_photo' => Utils::propsImg($_FILES['profile_img']), 'profile_banner' => Utils::propsImg($_FILES['profile_banner'])];
                    $update = $this->usuario->update($datos, $img, $message);
                    if ($update === true) {
                        if (Utils::isAdmin() &&  $adminview) {
                            $this->pages->render('admin/users', ['usuarios' => $this->usuario->getall()]);
                        } else {
                            $this->pages->render('usuario/profilesettings', ['message' => $message, 'datos_guardados' => $datos]);
                        }
                    } else if (gettype($update) === "array") {
                        if (Utils::isAdmin()) {
                            $this->pages->render('usuario/edit_user', ['message' => $update, 'datos' => "", 'id' => $id]);
                        } else {
                            $this->pages->render('usuario/profilesettings', ['message' => $update, 'datos_guardados' => $datos]);
                        }
                    }
                } else {
                    $this->pages->render('usuario/profilesettings', ['message' => $message, 'datos_guardados' => ""]);
                }
            }
        }else{
            Utils::irLogin();
        }
    }




    public function perfil()
    {

        if (Utils::isLogged()) {
            $this->pages->render('usuario/profile');
        } else {
            Utils::irLogin();
        }
    }

    public function autor()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datos = $_POST['data'];


            $this->pages->render('usuario/author');
        } else {
            $this->pages->render('usuario/author');
        }
    }



    public function gestionUsuarios()
    {

        if (Utils::isAdmin()) {
            $usuarios = $this->usuario->getall();
            $this->pages->render('admin/users', ['usuarios' => $usuarios]);
        } else {
            Utils::irModels();
        }
    }

    public function borrarUsuario($id)
    {
        if (Utils::isAdmin()) {
            $borrar = $this->usuario->borrar($id);
            if ($borrar) {
                $this->pages->render('admin/users', ['usuarios' => $this->usuario->getall()]);
                return true;
            }
            $this->pages->render('admin/users', ['usuarios' => $this->usuario->getall()]);
        } else {
            Utils::irModels();
        }
    }

    public static function obtenerNombreUsuario($id)
    {
        $usuario = new Usuario("", "", "", "", "", "", "", "", "", "");
        return $usuario->obtenerNombreUsuario($id);
    }
}
