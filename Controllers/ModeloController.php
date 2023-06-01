<?php


namespace Controllers;
use Lib\Pages;


class ModeloController{


    private Pages $pages;

    public function __construct(){

        $this -> pages = new Pages();
    }

    public function showAll(){
        $_SESSION['header'] = "";
        $this -> pages -> render("modelos/models");
    }

    public function crear(){
        $_SESSION['header'] = "";
        $this -> pages -> render("modelos/create_edit_model");
    }

    public function editar(){
        $_SESSION['header'] = "";
        $this -> pages -> render("modelos/create_edit_model");
    }

    public function mostrarModelo(){
        $_SESSION['header'] = "";
        $this -> pages -> render("modelos/modelview");
    }

    }






?>

