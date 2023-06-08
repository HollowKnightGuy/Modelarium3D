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



    public function solicitud($message = null)
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
                Utils::irProfile();
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
                    var_dump($solicitud);
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

    public function obtenerCreador($id)
    {

        $modelo_creador = $this->peticion->obtenerPeticionCreador($id);
        $id_usuario = $modelo_creador[0] -> id_usuario;
        $usuario = $this->intercontroller->obtenerUsuarioPorId($id_usuario);
        $peticion = $this -> peticion -> obtenerPeticion($modelo_creador[0] -> id);

        $this -> pages -> render('admin/requests/creators', ['modelo' => $modelo_creador, 'usuario' => $usuario, 'peticion' => $peticion]);

    }

    public function borrarPeticion($id){
        return $this -> peticion -> borrarPeticion($id);
    }

    public function obtenerPeticion($id_modelo){
        return $this -> peticion -> obtenerPeticion($id_modelo);
    }

    public function obtenerPeticionPorId($id){
        return $this -> peticion -> obtenerPeticionPorId($id);
    }


    public function rechazarSolicitud($type, $id)
    {
        if (Utils::isAdmin()) {
            if ($type === 'MO') {
                $delete = $this->intercontroller->borrarModelo($id);
                $deletePE = $this -> borrarPeticion($this -> obtenerPeticion($id)->id);
                if ($delete) {
                    $this->pages->render('admin/requests/models', ['rechazada' => "Peticion rechazada correctamente"]);
                } else {
                    $this->pages->render('admin/requests/models', ['rechazada' => "Ha habido un error al procesar la peticion"]);
                }
            }

            elseif ($type === 'BC') {

                $deleteMO = $this->intercontroller->borrarModelo($this -> obtenerPeticion($id)->id_modelo);
                $deletePE = $this -> borrarPeticion($id);
                if ($deleteMO && $deletePE) {
                    $this->pages->render('admin/requests/models', ['rechazada' => "Peticion rechazada correctamente"]);
                } else {
                    $this->pages->render('admin/requests/models', ['rechazada' => "Ha habido un error al procesar la peticion"]);
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
                $insert = $this->intercontroller->cambiarEstadoModelo($id);
                $deletePE = $this -> borrarPeticion($this -> obtenerPeticion($id)->id);
                if ($insert) {
                    //$this -> peticion -> aceptarPeticion($id_peticion);
                    $this->pages->render('admin/requests/models', ['aceptada' => "Peticion aceptada correctamente"]);
                } else {
                    $this->pages->render('admin/requests/models', ['aceptada' => "Ha habido un error al procesar la peticion"]);
                }
            }

            elseif ($type === 'BC') {

                $insert = $this->intercontroller->cambiarEstadoModelo($this -> obtenerPeticionPorId($id)->id_modelo);
                $id_usuario = $this -> obtenerPeticionPorId($id) -> id_usuario;
                $deletePE = $this -> borrarPeticion($id);

                $this -> intercontroller -> cambiaRol($id_usuario, 'ROLE_CREATOR');
                if ($insert && $deletePE) {
                    $this->pages->render('admin/requests/models', ['aceptada' => "Peticion aceptada correctamente"]);
                } else {
                    $this->pages->render('admin/requests/models', ['aceptada' => "Ha habido un error al procesar la peticion"]);
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