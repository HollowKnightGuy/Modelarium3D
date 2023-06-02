<?php


namespace Controllers;
use Lib\Pages;


class ModeloController{


    private Pages $pages;

    public function __construct(){

        $this -> pages = new Pages();
    }

    public function showAll(){
         
        $this -> pages -> render("modelos/models");
    }

    public function crear(){
         
        $this -> pages -> render("modelos/create_edit_model");
    }

    public function editar(){
         
        $this -> pages -> render("modelos/create_edit_model");
    }

    public function mostrarModelo(){
         
        $this -> pages -> render("modelos/modelview");
    }

    }






?>

