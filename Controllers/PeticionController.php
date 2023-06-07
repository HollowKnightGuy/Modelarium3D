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



    public function solicitud()
    {

        //TODO HACER QUE NO HAGAN FALTA LOS CONTROLADORES; POR EJEMPLO PASAR EL OBJETO USUARIO A ESTA FUNCIÓN EN LUGAR DE USAR EL CONTROLADOR

        if ($_SESSION['identity']->rol == 'ROLE_CREATOR') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $message = ['titulo' => "", 'precio' => "", 'descripcion_modelo' => "", 'modelo_glb' => "", 'modelo_foto' => ""];
                $datos = $_POST['data'];
                $file = $_FILES;
                $usuario = $this->intercontroller->obtenerUsuario($_SESSION['identity']->email);

                $peticion = $this->peticion->guardarPeticionModelo($message, $datos, $file, $usuario);
                if ($peticion === true) {
                    $this->pages->render('usuario/profile', ['message' => $message]);
                } else if (gettype($peticion) === "array") {
                    $this->pages->render('modelos/create_edit_model', ['message' => $peticion]);
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
                $message = ['email' => "", 'desc' => "", 'titulo' => "", 'precio' => "", 'descripcion_modelo' => "", 'modelo_glb' => "", 'modelo_foto' => ""];
                $datos = $_POST['data'];
                $archivos = $_FILES;
                $datos['archivo_modelo'] = $archivos['model_file'];
                $datos['foto_modelo'] = $archivos['model_photo'];
                $datos['id_usuario'] = $_SESSION['identity']->id;
                $this->intercontroller->crearModelo($datos);

                $usuario = $this->intercontroller->obtenerUsuario($_SESSION['identity']->email);

                $peticionCreador = $this->peticion->guardarPeticionCreador($message, $datos, $usuario);
                if($peticionCreador === true){
                    header("Location".$_ENV['BASE_URL']."profile/");
                }else{
                    $this -> pages -> render('usuario/creatorform', ['message' => $peticionCreador]);
                }
            } else {
                $this->pages->render('usuario/profile');
            }

        }

    }

    public function serCreador()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->solicitud();

            // TODO: MANDAR LOS DATOS Y CREAR LA PETICION DE SER CREADOR

            $this->pages->render('usuario/profile');

        } else {
            $this->pages->render('usuario/creatorform');
        }
    }

    public function obtenerCreatorsPendientes()
    {
        return $this->peticion->obtenerCreatorsPendientes();
    }

    public function obtenerCreador($id)
    {

        $modelo_creador = $this->peticion->obtenerPeticionCreador($id);

        $this -> pages -> render('admin/requests/creators', ['modelo' => $modelo_creador]);

    }


    public function rechazarSolicitud($type, $id)
    {
        if (Utils::isAdmin()) {
            if ($type === 'MO') {
                $delete = $this->intercontroller->borrarModelo($id);
                if ($delete) {
                    $this->pages->render('admin/requests/models', ['rechazada' => "Peticion rechazada correctamente"]);
                } else {
                    $this->pages->render('admin/requests', ['rechazada' => "Ha habido un error al procesar la peticion"]);
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
                if ($insert) {
                    // $this -> peticion -> aceptarPeticion($id_peticion);
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