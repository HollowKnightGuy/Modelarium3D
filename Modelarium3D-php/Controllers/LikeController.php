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

        public function obtenerModelosLiked($id_usuario){
            return $this -> like -> obtenerModelosLiked($id_usuario);
        }

        public function like($idmodelo, $view = false, $autor = false, $profile = false){
            if(Utils::isLogged()){
                $usuarioDadoLike = $this -> comprobarLike($_SESSION['identity']-> id, $idmodelo);


                if($usuarioDadoLike === false || $usuarioDadoLike === null){
                    
                    $insert = $this -> like -> insertLike($_SESSION['identity'] -> id, $idmodelo);
                    //TODO: BUENAS 
                    if(!$insert){
                        $this -> pages -> render("modelos/models");
                    }
                    else if($this -> intercontroller -> like($idmodelo)){
                        if($view === true) Utils::irView($idmodelo);
                        if($autor === true){
                            $idautor = $this -> intercontroller -> obtenerModeloPorId($idmodelo)->id_usuario;
                            Utils::irAutor($idautor);
                        }
                        if($profile === true){
                            Utils::irProfile();
                        }else if(!$autor && !$view && !$profile){
                            $view ? Utils::irView($idmodelo) : Utils::irModels();
                        }
                    }
                }else{
                    $revertir = $this -> like -> deleteLike($_SESSION['identity'] -> id, $idmodelo);
                    if(!$revertir){
                        $this -> pages -> render("modelos/models");
                    }
                    else if($this -> intercontroller -> revertirLike($idmodelo)){
                        if($view === true) Utils::irView($idmodelo);
                        if($autor === true){
                            $idautor = $this -> intercontroller -> obtenerModeloPorId($idmodelo)->id_usuario;
                            Utils::irAutor($idautor);
                        }
                        if($profile === true){
                            Utils::irProfile();
                        }else if(!$autor && !$view && !$profile){
                            $view ? Utils::irView($idmodelo) : Utils::irModels();
                        }     
                    }
                }
            }else{
                Utils::irLogin();
            }
        }
    }
