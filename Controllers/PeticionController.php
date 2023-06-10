<?php


namespace Controllers;

use Lib\Pages;
use Lib\Utils;
use Models\Peticion;
use Controllers\InterController;

class PeticionController
{

    private Utils $utils;
    private Pages $pages;
    private Peticion $peticion;
    private InterController $intercontroller;

    public function __construct()
    {
        $this->utils = new Utils();
        $this->pages = new Pages();
        $this->peticion = new Peticion(0, 0, 0, 0, 0);
        $this->intercontroller = new InterController();
    }



    public function solicitud($message = null, $comentario = null, $id_comentario = null)
    {

        if (Utils::isCreator()) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $message = ['titulo' => "", 'precio' => "", 'descripcion_modelo' => "", 'modelo_glb' => "", 'modelo_foto' => ""];
                $_POST['data']['price'] = number_format($_POST['data']['price'], 2, '.', '');
                $datos = $_POST['data'];
                $file = $_FILES;

                $usuario = $this->intercontroller->obtenerUsuario($_SESSION['identity']->email);
                
                $peticion = $this->peticion->guardarPeticionModelo($message, $datos, $file, $usuario);
                if ($peticion === true) {
                    $this->pages->render('usuario/profile', ['message' => $message]);
                } else if (gettype($peticion) === "array") {
                    $this->pages->render('modelos/create_edit_model', ['message' => $peticion, "datos_guardados" => $datos]);
                } else {
                    $this->pages->render('usuario/profile');
                }
            } else {
                $this->pages->render('usuario/profile');
            }


        } elseif (Utils::isAdmin()) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            } else {
                $this->pages->render('admin/requests/models');
            }

        }else if($comentario === 'rep' and $id_comentario !== null){
            if(Utils::isLogged()){
                $comentarioObj = $this -> intercontroller -> obtenerComentarioPorId($id_comentario);
                if($comentarioObj -> id === Utils::idLoggedUsuario()){
                    $this -> pages -> render('modelos/modelview', ['error_reportar_tu_comentario' => 'You can'."'".'report your comment']);
                    return false;
                }
                if($comentarioObj -> reportado !== NULL){
                    $_SESSION['esta_reportado'] = "This comment is already reported";
                    Utils::irView($comentarioObj -> id_modelo);
                }else{
                    $_SESSION['esta_reportado'] = "";

                    // $this -> intercontroller -> obtenerComentario($id_comentario);
                    $reportado = true;
                    $this -> peticion -> guardarPeticionComentarioRep($comentarioObj);
                    $this -> intercontroller -> cambiarEstadoComentario($reportado, $id_comentario);
                    Utils::irView($comentarioObj -> id_modelo);
                }
            }else{
                Utils::irLogin();
            }
        } else {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST['data']['price'] = number_format($_POST['data']['price'], 2, '.', '');
                $datos = $_POST['data'];
                $archivos = $_FILES;
                $datos['archivo_modelo'] = $archivos['model_file'];
                $datos['foto_modelo'] = $archivos['model_photo'];
                $datos['id_usuario'] = $_SESSION['identity']->id;
                
                $usuario = $this->intercontroller->obtenerUsuario($_SESSION['identity']->email);
                $peticionCreador = $this->peticion->guardarPeticionCreador($message, $datos, $usuario);
                if($peticionCreador === true){
                    return true;
                }else{
                    return $peticionCreador;
                }
            } else {
                if(Utils::isLogged()){
                    Utils::irProfile();
                }else{
                    Utils::irLogin();
                }
            }

        }

    }

    public function serCreador()
    {
        if(!Utils::isCreator() && Utils::isLogged()){
            // if($this -> existePeticion($_SESSION['identity'] -> id, 'BC') === true){
            //     $_SESSION['peticion_mandada'] = true;
            //     Utils::irProfile();
            //     return;
            // }

            $_SESSION['peticion_mandada'] = false;
            $message = ['email' => "", 'desc' => "", 'titulo' => "", 'precio' => "", 'descripcion_modelo' => "", 'modelo_glb' => "", 'modelo_foto' => ""];
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $solicitud = $this -> solicitud($message);
                if($solicitud !== true){
                    $this -> pages -> render('usuario/creatorform', ['message' => $solicitud, 'datos_guardados' => $_POST['data']]);
                }else{                    
                    Utils::irProfile();
                }
            } else {
                $this->pages->render('usuario/creatorform',  ['message' => $message, 'datos_guardados' => []]);
            }
        }else if(!Utils::isLogged()){
            Utils::irLogin();
        }else{
            Utils::irModels();
        }
    }

    public function existePeticion($idusuario, $tipo){
        return $this -> peticion -> existePeticion($idusuario, $tipo);
    }

    public function obtenerCreatorsPendientes()
    {
        return $this->peticion->obtenerCreatorsPendientes();
    }

    public function obtenerComentariosPendientes()
    {
        return $this->peticion->obtenerComentariosPendientes();
    }

    public function obtenerCreador($id)
    {

        $modelo_creador = $this->peticion->obtenerPeticionCreador($id);
        $id_usuario = $modelo_creador[0] -> id_usuario;
        $usuario = $this->intercontroller->obtenerUsuarioPorId($id_usuario);
        $peticion = $this -> peticion -> obtenerPeticion($modelo_creador[0] -> id);

        $this -> pages -> render('admin/requests/creators', ['modelo' => $modelo_creador, 'usuario' => $usuario, 'peticion' => $peticion]);

    }

    public function obtenerComentario($id_comentario)
    {
        $comentario = $this -> intercontroller -> obtenerComentarioPorId($id_comentario);
        $modelo = $this -> intercontroller -> obtenerModeloPorId($comentario -> id_modelo);
        $usuario = $this->intercontroller->obtenerUsuarioPorId($comentario -> id_usuario);
        $peticion = $this -> peticion -> obtenerPeticionComentario($comentario -> id);

        $this -> pages -> render('admin/requests/comments', ['modelo' => $modelo, 'usuario' => $usuario, 'comentario' => $comentario, 'peticion' => $peticion]);

    }

    public function borrarPeticion($id){
        return $this -> peticion -> borrarPeticion($id);
    }

    public function obtenerPeticion($id_modelo){
        return $this -> peticion -> obtenerPeticion($id_modelo);
    }
    
    public function obtenerPeticionComentario($id_comentario){
        return $this -> peticion -> obtenerPeticionComentario($id_comentario);
    }
    
    public function obtenerPeticionPorId($id){
        return $this -> peticion -> obtenerPeticionPorId($id);
    }
    
    
    public function rechazarSolicitud($type, $id)
    {
        if (Utils::isAdmin()) {
            if ($type === 'MO') {
                $delete = $this->intercontroller->borrarModelo($id);
                $borrarPeticion = $this -> borrarPeticion($this -> obtenerPeticion($id)->id);
                if ($delete) {
                    $this->pages->render('admin/requests/models', ['rechazada' => "Peticion rechazada correctamente"]);
                } else {
                    $this->pages->render('admin/requests/models', ['rechazada' => "Ha habido un error al procesar la peticion"]);
                }
            }

            elseif ($type === 'BC') {

                $delete = $this->intercontroller->borrarModelo($this -> obtenerPeticion($id)->id_modelo);
                $borrarPeticion = $this -> borrarPeticion($id);
                if ($delete && $borrarPeticion) {
                    $this->pages->render('admin/requests/models', ['rechazada' => "Peticion rechazada correctamente"]);
                } else {
                    $this->pages->render('admin/requests/models', ['rechazada' => "Ha habido un error al procesar la peticion"]);
                }
            }
            elseif ($type === 'CO') {
                $cambiarEstado = $this -> intercontroller -> cambiarEstadoComentario(false, $this -> obtenerPeticionPorId($id)->id_comentario );
                $borrarPeticion = $this -> borrarPeticion($id);
                if ($cambiarEstado && $borrarPeticion) {
                    $this->pages->render('admin/requests/models', ['aceptada' => "Peticion aceptada correctamente"]);
                } else {
                    $this->pages->render('admin/requests/models', ['aceptada' => "Ha habido un error al procesar la peticion"]);
                }
            }
        } else {
            $this->pages->render("modelos/models");
        }
    }

    public function aceptarSolicitud($type, $id)
    {
        if (Utils::isAdmin()) {
            if ($type === 'MO') {
                $cambiarEstado = $this->intercontroller->cambiarEstadoModelo($id);
                $borrarPeticion = $this -> borrarPeticion($this -> obtenerPeticion($id)->id);
                if ($cambiarEstado) {
                    //$this -> peticion -> aceptarPeticion($id_peticion);
                    $this->pages->render('admin/requests/models', ['aceptada' => "Peticion aceptada correctamente"]);
                } else {
                    $this->pages->render('admin/requests/models', ['aceptada' => "Ha habido un error al procesar la peticion"]);
                }
            }

            elseif ($type === 'BC') {

                $cambiarEstado = $this->intercontroller->cambiarEstadoModelo($this -> obtenerPeticionPorId($id)->id_modelo);
                $id_usuario = $this -> obtenerPeticionPorId($id) -> id_usuario;
                $borrarPeticion = $this -> borrarPeticion($id);

                $this -> intercontroller -> cambiaRol($id_usuario, 'ROLE_CREATOR');
                if ($cambiarEstado && $borrarPeticion) {
                    $this->pages->render('admin/requests/models', ['aceptada' => "Peticion aceptada correctamente"]);
                } else {
                    $this->pages->render('admin/requests/models', ['aceptada' => "Ha habido un error al procesar la peticion"]);
                }
                
            }elseif ($type === 'CO') {
                $id_comentario = $this -> obtenerPeticionPorId($id) -> id_comentario;
                $borrarPeticion = $this -> borrarPeticion($id);
                $delete = $this->intercontroller->borrarComentario($id_comentario);
                if ($delete && $borrarPeticion) {
                    $this->pages->render('admin/requests/models', ['rechazada' => "Peticion rechazada correctamente"]);
                } else {
                    $this->pages->render('admin/requests/models', ['rechazada' => "Ha habido un error al procesar la peticion"]);
                }
            }
        } else {
            $this->pages->render("modelos/models");
        }
    }


    // public function obtenerModelo($id_usuario, $titulo){
    //     $this -> mcontroller -> obtenerModelo($id_usuario, $titulo);
    // }


}