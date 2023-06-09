<?php

namespace Lib;

class Utils{
    public static function deleteSession($name):string{
        // BORRA LA SESSION 
        if(isset($_SESSION[$name])){
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }

        return $name;
    }
    
        public static function isLogged():bool{
            // COMPRUEBA SI HAY ALGUIEN LOGUEADO
            if(isset($_SESSION['identity'])){
                return true;
            }
            else{
                return false;
            }
        }

    public static function isAdmin():bool{
        // COMPRUEBA SI LA SESSION ESTA INICIADA POR UN ADMIN
        if(isset($_SESSION['admin']) && $_SESSION['admin'] === true){
            return true;
        }
        else{
            return false;
        }
    }

    public static function isCreator():bool{
        // COMPRUEBA SI HAY ALGUIEN LOGUEADO
        if(isset($_SESSION['identity']) && $_SESSION['identity'] -> rol === 'ROLE_CREATOR'){
            return true;
        }
        else{
            return false;
        }
    }

    public static function propsImg($img):array|bool{
        if($img['tmp_name'] === ""){
            return false;
        }else{
            list($ancho, $alto) = getimagesize( $img['tmp_name']);
            $peso = $img['size'] / 1024;
            $propiedadesImg = ['ancho' => $ancho, 'alto' => $alto, 'tipo' => explode("/", $img['type'])[1], 'peso' => $peso];
            return $propiedadesImg;
        }
    }

    public static function propsModelo($modelo):array|bool{
        if($modelo['tmp_name'] === ""){
            return false;
        }else{
            list($ancho, $alto) = getimagesize( $modelo['tmp_name']);
            $peso = $modelo['size'] / 1024;
            $propiedadesModelo = ['ancho' => $ancho, 'alto' => $alto, 'tipo' => explode(".", $modelo['name'])[1], 'peso' => $peso];
            return $propiedadesModelo;
        }
    }

    public static function idLoggedUsuario(){
        if(isset($_SESSION['identity'])){
            return $_SESSION['identity']->id;
        }else{
            return false;
        }
    }

    
	public static function validarImagenPerfil($img, $message):array{
        $img = Utils::propsImg($img);
        if($img !== false){
            if ($img['tipo'] != 'jpg' && $img['tipo'] != 'jpeg' && $img['tipo'] != 'png') {
                $message['imagen'] = "The image type must be jpg/jpeg/png";
            } else if ($img['ancho'] != $img['alto']) {
                $message['imagen'] = "Profile picture must be square";
            } else if ($img['peso'] > 150) {
                $message['imagen'] = "The image of the maximum must weigh 150KB";
            }
        }
		return $message;
	}

	public static function validarImagenBanner($banner, $message):array{
        $banner = Utils::propsImg($banner);
        if($banner !== false){
            if ($banner['tipo'] != 'jpg' && $banner['tipo'] != 'jpeg' && $banner['tipo'] != 'png') {
                $message['imagenbanner'] = "The image type must be jpg/jpeg/png";
            }else if ($banner['peso'] > 75) {
                $message['imagenbanner'] = "The image of the maximum must weigh 75KB";
            }
        }

		return $message;
	}


    public static function validarImagenModelo($img, $message):array{
        $img = Utils::propsImg($img);
        if($img !== false){
            if ($img['tipo'] != 'jpg' && $img['tipo'] != 'jpeg' && $img['tipo'] != 'png') {
                $message['modelo_foto'] = "The image type must be jpg/jpeg/png";
            } else if ($img['ancho'] > $img['alto']) {
                $message['modelo_foto'] = "The model image must be taller than it is wide";
            } else if ($img['peso'] > 150) {
                $message['modelo_foto'] = "The image of the maximum must weigh 125KB";
            }
        }
		return $message;
	}

    public static function validarArchivoModelo($modelo, $message):array{
        $modelo = Utils::propsModelo($modelo);
        if($modelo !== false){
            if ($modelo['tipo'] != 'glb') {
                $message['modelo_glb'] = "The file type must be .gbl";
            } else if ($modelo['peso'] > 300) {
                $message['modelo_glb'] = "The model must weigh a maximum of 300KB";
            }
        }
		return $message;
	}

    public static function comprobarErrores($lista)
	{
		foreach ($lista as $error) {
			if (!empty($error)) {
				return false;
			}
		}
		return true;
	}

    public static function irLogin(){
        header("Location:".$_ENV['BASE_URL']."login");
    }

    
    public static function irModels(){
        header("Location:".$_ENV['BASE_URL']."models/");
    }

    public static function irView($idmodelo){
        header("Location:".$_ENV['BASE_URL']."models/view/id=".$idmodelo);
    }

    
    public static function irAutor($idautor){
        header("Location:".$_ENV['BASE_URL']."profile/autor/id=".$idautor);
    }

    public static function irProfile(){
        header("Location:".$_ENV['BASE_URL']."profile/");
    }
}

?>