<?php 

    namespace Controllers;
    use Lib\Pages;
    use Lib\Utils;
    use Models\Favoritos;
    use Controllers\InterController;
    

    class FavoritosController{
        private Pages $pages;
        private Favoritos $favoritos;
        private InterController $intercontroller;

        public function __construct(){
            $this -> pages = new Pages();
            $this -> favoritos = new Favoritos("","","");
            $this -> intercontroller = new InterController();
        }

        public function comprobarFavorito($idusuario, $idmodelo){
            return $this -> favoritos -> comprobarFavorito($idusuario, $idmodelo);
        }

        public function favorito($idmodelo){
            if(Utils::isLogged()){
                $usuarioDadoFav = $this -> comprobarFavorito($_SESSION['identity']-> id, $idmodelo);

                $idmodelo = $this -> intercontroller -> obtenerModeloPorId($idmodelo)[0] -> id;

                if($usuarioDadoFav === false || $usuarioDadoFav === null){
                    $insert = $this -> favoritos -> insertFavorito($_SESSION['identity'] -> id, $idmodelo);
                    if(!$insert){
                        $_SESSION['error_fav'] = "Ha habido un error al dar favorito, intentelo de nuevo";
                        $this -> pages -> render("modelos/models");
                    }
                    else if($this -> intercontroller -> favorito($idmodelo)){
                        $_SESSION['error_fav'] = "";
                        header("Location:".$_ENV['BASE_URL']."models/");
                    }
                }else{
                    $revertir = $this -> favoritos -> deleteFavorito($_SESSION['identity'] -> id, $idmodelo);
                    if(!$revertir){
                        $_SESSION['error_fav'] = "Ha habido un error al quitar el favoritos intentelo de nuevo";
                        $this -> pages -> render("modelos/models");
                    }
                    else if($this -> intercontroller -> revertirFavorito($idmodelo)){
                        $_SESSION['error_fav'] = "";
                        header("Location:".$_ENV['BASE_URL']."models/");
                    }
                }
            }else{
                $this -> pages -> render('usuario/login');
            }
        }
    }
