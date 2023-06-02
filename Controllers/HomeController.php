<?php


namespace Controllers;
use Lib\Pages;


class HomeController{

    private Pages $pages;

    public function __construct(){

        $this -> pages = new Pages();
    }

    public function index(){
        $this -> pages -> render("landing");
    }

    public function contacto(){
        $this -> pages -> render("contact");
    }

    public function aboutus(){
        $this -> pages -> render("aboutus");

    }

    public function IrHabitacion(){
        $this -> pages -> render("room");



        }
    }

?>

