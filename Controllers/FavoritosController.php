<?php 

    namespace Controllers;
    use Lib\Pages;
    use Lib\Utils;
    use Models\Favoritos;
    use Controllers\InterController;
    

    class FavoritosController {
        private Pages $pages;
        private Favoritos $favoritos;
        private InterController $intercontroller;
    
        public function __construct() {
            $this->pages = new Pages();
            $this->favoritos = new Favoritos("", "", "");
            $this->intercontroller = new InterController();
        }
    
        public function comprobarFavorito($idusuario, $idmodelo) {
            return $this->favoritos->comprobarFavorito($idusuario, $idmodelo);
        }
    
        public function favorito($idmodelo, $view = false, $autor = false, $profile = false) {
            if (Utils::isLogged()) {
                $usuarioDadoFav = $this->comprobarFavorito($_SESSION['identity']->id, $idmodelo);
                $idmodelo = $this->intercontroller->obtenerModeloPorId($idmodelo)->id;
                
                if ($usuarioDadoFav === false || $usuarioDadoFav === null) {
                    $insert = $this->favoritos->insertFavorito($_SESSION['identity']->id, $idmodelo);
                    if (!$insert) {
                        $_SESSION['error_fav'] = "Ha habido un error al dar favorito, intentelo de nuevo";
                        $this->pages->render("modelos/models");
                    } else if ($this->intercontroller->favorito($idmodelo)) {
                        if ($view === true) Utils::irView($idmodelo);
                        if ($autor === true) {
                            $idautor = $this->intercontroller->obtenerModeloPorId($idmodelo)->id_usuario;
                            Utils::irAutor($idautor);
                        } 
                        if($profile === true){
                            Utils::irProfile();
                        }else if(!$autor && !$view && !$profile){
                            $view ? Utils::irView($idmodelo) : Utils::irModels();
                        }
                    }
                } else {
                    $revertir = $this->favoritos->deleteFavorito($_SESSION['identity']->id, $idmodelo);
                    if (!$revertir) {
                        $_SESSION['error_fav'] = "Ha habido un error al quitar el favoritos intentelo de nuevo";
                        $this->pages->render("modelos/models");
                    } else if ($this->intercontroller->revertirFavorito($idmodelo)) {
                        if ($view === true) Utils::irView($idmodelo);
                        if ($autor === true) {
                            $idautor = $this->intercontroller->obtenerModeloPorId($idmodelo)->id_usuario;
                            Utils::irAutor($idautor);
                        } 
                        if($profile === true){
                            Utils::irProfile();
                        }else if(!$autor && !$view && !$profile){
                            $view ? Utils::irView($idmodelo) : Utils::irModels();
                        }
                    }
                }
            } else {
                $this->pages->render('usuario/login');
            }
        }

        public function obtenerModelosFav($id_usuario){
            return $this -> favoritos -> obtenerModelosFav($id_usuario);
        }
    }
