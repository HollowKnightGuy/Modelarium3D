<?php


namespace Controllers;
use Lib\Pages;
use Lib\Utils;
use Models\Comentario;



class ComentariosController{

    private Utils $utils;
    private Pages $pages;
    private Comentario $comentario;

    public function __construct(){
        $this -> utils = new Utils();
        $this -> pages = new Pages();
        $this -> comentario = new Comentario("", "", "", "", "", "");
    }


	public function comentar($id_modelo){
		
		if(Utils::isLogged()){
            $_SESSION['esta_reportado'] = "";
			if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $message = ['comment' => ""];
                $comentario_texto = $_POST['comment'];
                $comentario = $this -> comentario -> comentar($id_modelo, $comentario_texto, $message);
                if($comentario !== true){
                    $comentarios = $this -> obtenerComentarios($id_modelo);    

                    $this -> pages -> render('modelos/modelview', ['message' => $comentario,'comentarios' => $comentarios, 'comentario_texto' => $comentario_texto]);
                }else{
                    Utils::irView($id_modelo);
                    
                    // $this -> pages -> render('modelos/modeview', ['message' => "", 'comentario' => ""]);
                }
            }
		}else{
			Utils::irLogin();
		}
		
	}

    public function obtenerComentarios($idmodelo){
        return $this -> comentario -> obtenerComentarios($idmodelo);
    }

    public function obtenerComentarioPorId($id_comentario){
        return $this -> comentario -> obtenerComentarioPorId($id_comentario);
    }

    public function cambiarEstadoComentario($reportado, $id_comentario){
        return $this -> comentario -> cambiarEstadoComentario($reportado, $id_comentario);
    }

    public function borrarComentario($id_comentario){
        return $this -> comentario -> borrarComentario($id_comentario);
    }
}


?>