<?php


namespace Controllers;
use Lib\Pages;


class HomeController{

    private Pages $pages;

    public function __construct(){

        $this -> pages = new Pages();
    }

    public function index(){
        $_SESSION['header'] = "landingheader.php";
        $this -> pages -> render("landing");
    }

    public function contacto(){
        $_SESSION['header'] = "contactheader.php";
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

