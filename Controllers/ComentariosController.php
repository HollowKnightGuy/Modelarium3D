<?php


namespace Controllers;
use Lib\Pages;
use Lib\Utils;
use Models\Comentario;


class ComentarioController{

    private Utils $utils;
    private Pages $pages;
    private Comentario $comentario;

    public function __construct(){
        $this -> utils = new Utils();
        $this -> pages = new Pages();
        $this -> comentario = new Comentario("", "", "", "", "", "");


    }


	public function crear($data){
		
		if(Utils::isLogged()){
			if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $iduser = $_SESSION['identity']['id'];

                $datos = $_POST['data'];
                //$this -> comentario -> comentar();
            }
		}else{
			$this -> pages -> render("login");
		}
		
	}


}


?>