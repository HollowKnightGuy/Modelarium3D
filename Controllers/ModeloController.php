<?php

namespace Controllers;
use Controllers\ComentariosController;
use Models\Modelo;
use Lib\Pages;
use Lib\Utils;

class ModeloController
{


    private Pages $pages;
    private ComentariosController $comentarioC;
    private Modelo $modelo;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->comentarioC = new ComentariosController();
        $this->modelo = new Modelo("", "", "", "", "", "", "", "", "", "", "", "", "", "");
    }

    public function showAll()
    {
        $modelos = $this->modelo->obtenerModelos();
        $this->pages->render("modelos/models", ['modelos' => $modelos]);
    }

    public function obtenerModelosPendientes()
    {
        return $this->modelo->obtenerModelosPendientes();
    }

    public function crear($datos = NULL)
    {
        $message = ['titulo' => "", 'precio' => "", 'descripcion_modelo' => "", 'modelo_glb' => "", 'modelo_foto' => ""];

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            return $this->modelo->guardar($datos);
        } else {
            $this->pages->render("modelos/create_edit_model", ['message' => $message]);
        }
    }

    public function editar()
    {
        if(Utils::isCreator() || Utils::isAdmin()){
            $this->pages->render("modelos/create_edit_model");
        }else{
            Utils::irModels();
        }
    }

    public function cambiarEstado($id)
    {
        return $this->modelo->cambiarEstado($id);
    }

    public function borrar($id)
    {
        if(Utils::isCreator() || Utils::isAdmin()){
            return $this->modelo->borrar($id);
        }
    }

    public function mostrarModelo($id_modelo)
    {
        $modelo = $this -> obtenerModeloPorId($id_modelo);
        if(!is_object($modelo[0])) Utils::irModels();
        $comentarios = $this -> comentarioC -> obtenerComentarios($id_modelo);    
        $this->pages->render("modelos/modelview", ['modelo' => $modelo[0], 'comentarios' => $comentarios]);
    }

    public function obtenerModelo($id_usuario, $titulo)
    {
        return $this->modelo->obtenerModelo($id_usuario, $titulo);
    }

    public function obtenerModeloPorId($idmodelo)
    {
        return $this->modelo->obtenerModeloPorId($idmodelo);
    }

    public function obtenerModelosUsuario($idusuario)
    {
        return $this->modelo->obtenerModelosUsuario($idusuario);
    }
    

    public function like($idmodelo)
    {
        if (Utils::isLogged()) {
            return $this->modelo->like($idmodelo);
        } else {
            Utils::irLogin();
        }
    }

    public function revertirLike($idmodelo)
    {
        if (Utils::isLogged()) {
            return $this->modelo->revertirLike($idmodelo);
        } else {
            Utils::irLogin();
        }
    }

    public function favorito($idmodelo)
    {
        if (Utils::isLogged()) {
            return $this->modelo->favorito($idmodelo);
        } else {
            Utils::irLogin();
        }
    }

    public function revertirFavorito($idmodelo)
    {
        if (Utils::isLogged()) {
            return $this->modelo->revertirFavorito($idmodelo);
        } else {
            Utils::irLogin();
        }
    }
}
