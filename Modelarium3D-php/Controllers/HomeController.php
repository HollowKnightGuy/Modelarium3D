<?php


namespace Controllers;
use Lib\Pages;
use Lib\Utils;use Lib\Email;
use Models\Contacto;

class HomeController{

    private Pages $pages;
    private Email $email;
    private Contacto $contacto;
    
    public function __construct(){
        $this -> pages = new Pages();
        $this->email = new Email();
        $this -> contacto = new Contacto();
    }

    public function index(){
        $this -> pages -> render("landing");
    }

    public function contacto(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $message = ['nombre_email' => "", "desc" => ""];
            if(Utils::isLogged()){
                $datos = $_POST['data'];
                $contacto = $this -> contacto -> contacto($datos, $message);
                if($contacto !== true){
                    $this -> pages -> render('contact', ['message' => $contacto]);
                }else{
                    $this -> email -> contacto($datos['name'], $datos['email'], $datos['desc']);
                    $this -> pages -> render('contact', ['enviado' => true]);

                }
            }else{
                Utils::irLogin();
            }
        }else{
            $this -> pages -> render("contact");
        }
    }

    public function aboutus(){
        $this -> pages -> render("aboutus");

    }

    public function IrHabitacion(){
        $this -> pages -> render("room");



        }
    }

?>

