<?php
namespace Controllers;

use Models\Modelo;
use Lib\Pages;

class ModeloController{


    private Pages $pages;
    private Modelo $modelo;

    public function __construct(){
        $this -> pages = new Pages();
        $this -> modelo = new Modelo("", "", "", "", "", "", "", "", "", "", "", "");
    }

    public function showAll(){
         
        $this -> pages -> render("modelos/models");
    }

    public function obtenerPendientes(){
        return $this -> modelo -> obtenerPendientes();
    }

    public function crear($datos = NULL){
        $message = ['titulo' => "", 'precio' => "", 'descripcion_modelo' => "", 'modelo_glb' => "", 'modelo_foto' => ""];

        if($_SERVER['REQUEST_METHOD'] === "POST"){
            return $this -> modelo -> guardar($datos);
        }else{
            $this -> pages-> render("modelos/create_edit_model", ['message' => $message]);
        }

    }

    public function editar(){
         
        $this -> pages -> render("modelos/create_edit_model");
    }

    public function mostrarModelo(){
         
        $this -> pages -> render("modelos/modelview");
    }

    public function obtenerModelo($id_usuario, $titulo){
        return $this -> modelo -> obtenerModelo($id_usuario, $titulo);
    }

    }






?>

