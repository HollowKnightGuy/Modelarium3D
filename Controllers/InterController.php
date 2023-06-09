<?php 

namespace Controllers;
use Controllers\UsuarioController;
use Controllers\ModeloController;
use Controllers\ComentariosController;



class InterController{

    private UsuarioController $usuarioC;
    private ModeloController $modeloC;
    private ComentariosController $comentarioC;



    public function __construct(){
        $this -> usuarioC = new UsuarioController();
        $this -> modeloC = new ModeloController();
        $this -> comentarioC = new ComentariosController();
    }
    
    public function obtenerUsuario($email){
        return $this -> usuarioC -> obtenerUsuario($email);
    }

    public function obtenerUsuarioPorId($id){
        return $this -> usuarioC -> obtenerUsuarioPorId($id);
    }

    public function borrarModelo($id){
        return $this -> modeloC -> borrar($id);
    }

    public function cambiarEstadoModelo($id){
        return $this -> modeloC -> cambiarEstado($id);
    }

    public function crearModelo($datos){
        return $this -> modeloC -> crear($datos);
    }

    public function obtenerModelo($id_usuario, $titulo){
        return $this -> modeloC -> obtenerModelo($id_usuario, $titulo);
    }

    public function mostrarModelo($id_modelo){
        return $this -> modeloC -> mostrarModelo($id_modelo);
    }

    public function like($idmodelo){
        return $this -> modeloC -> like($idmodelo);
    }

    public function revertirLike($idmodelo){
        return $this -> modeloC -> revertirLike($idmodelo);
    }

    public function favorito($idmodelo){
        return $this -> modeloC -> favorito($idmodelo);
    }

    public function revertirFavorito($idmodelo){
        return $this -> modeloC -> revertirFavorito($idmodelo);
    }

    public function cambiaRol($id_usuario, $rol){
        return $this -> usuarioC -> cambiaRol($id_usuario, $rol);
    }


    public function obtenerModeloPorId($idmodelo){
        return $this -> modeloC -> obtenerModeloPorId($idmodelo);
    }

    public function obtenerModelosUsuario($idusuario){
        return $this -> modeloC -> obtenerModelosUsuario($idusuario);
    }
    public function cambiarEstadoComentario($reportado, $id_comentario){
        return $this -> comentarioC -> cambiarEstadoComentario($reportado, $id_comentario);
    }
    public function obtenerComentarioPorId($id_comentario){
        return $this -> comentarioC -> obtenerComentarioPorId($id_comentario);
    }
    public function borrarComentario($id_comentario){
        return $this -> comentarioC -> borrarComentario($id_comentario);
    }
}
?>