<?php 

    namespace Controllers;
    use Lib\Pages;
    use Lib\Utils;
    use Models\Like;
    use Controllers\InterController;
    

    class LikeController{
        private Pages $pages;
        private Like $like;
        private InterController $intercontroller;

        public function __construct(){
            $this -> pages = new Pages();
            $this -> like = new Like("","","");
            $this -> intercontroller = new InterController();
        }

        public function comprobarLike($idusuario, $idmodelo){
            return $this -> like -> comprobarLike($idusuario, $idmodelo);
        }

        public function like($idmodelo, $view = false){
            if(Utils::isLogged()){
                $usuarioDadoLike = $this -> comprobarLike($_SESSION['identity']-> id, $idmodelo);

                $idmodelo = $this -> intercontroller -> obtenerModeloPorId($idmodelo)[0] -> id;

                if($usuarioDadoLike === false || $usuarioDadoLike === null){
                    $insert = $this -> like -> insertLike($_SESSION['identity'] -> id, $idmodelo);
                    if(!$insert){
                        $_SESSION['error_like'] = "Ha habido un error al dar like, intentelo de nuevo";
                        $this -> pages -> render("modelos/models");
                    }
                    else if($this -> intercontroller -> like($idmodelo)){
                        $_SESSION['error_like'] = "";
                        $view ? Utils::irView($idmodelo) : Utils::irModels();
                    }
                }else{
                    $revertir = $this -> like -> deleteLike($_SESSION['identity'] -> id, $idmodelo);
                    if(!$revertir){
                        $_SESSION['error_like'] = "Ha habido un error al quitar like, intentelo de nuevo";
                        $this -> pages -> render("modelos/models");
                    }
                    else if($this -> intercontroller -> revertirLike($idmodelo)){
                        $_SESSION['error_like'] = "";
                        $view ? Utils::irView($idmodelo) : Utils::irModels();
                    }
                }
            }else{
                Utils::irLogin();
            }
        }
    }
