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

    
	public static function validarImagenPerfil($img, $message):array{
        $img = Utils::propsImg($img);
        if($img !== false){
            if ($img['tipo'] != 'jpg' && $img['tipo'] != 'jpeg' && $img['tipo'] != 'png') {
                $message['imagen'] = "El tipo de la imagen debe ser jpg/jpeg/png";
            } else if ($img['ancho'] != $img['alto']) {
                $message['imagen'] = "La imagen de perfil debe ser cuadrada";
            } else if ($img['peso'] > 150) {
                $message['imagen'] = "La imagen de perfil como máximo debe pesar 150KB";
            }
        }
		return $message;
	}

	public static function validarImagenBanner($banner, $message):array{
        $banner = Utils::propsImg($banner);
        if($banner !== false){
            if ($banner['tipo'] != 'jpg' && $banner['tipo'] != 'jpeg' && $banner['tipo'] != 'png') {
                $message['imagenbanner'] = "El tipo de la imagen debe ser jpg/jpeg/png";
            }else if ($banner['peso'] > 75) {
                $message['imagenbanner'] = "El banner como máximo debe pesar 75KB";
            }
        }

		return $message;
	}


    public static function validarImagenModelo($img, $message):array{
        $img = Utils::propsImg($img);
        if($img !== false){
            if ($img['tipo'] != 'jpg' && $img['tipo'] != 'jpeg' && $img['tipo'] != 'png') {
                $message['modelo_foto'] = "El tipo de la imagen debe ser jpg/jpeg/png";
            } else if ($img['ancho'] > $img['alto']) {
                $message['modelo_foto'] = "La imagen del modelo debe tener mas alto que ancho";
            } else if ($img['peso'] > 150) {
                $message['modelo_foto'] = "La imagen del como máximo debe pesar 125KB";
            }
        }
		return $message;
	}

    public static function validarArchivoModelo($modelo, $message):array{
        $modelo = Utils::propsModelo($modelo);
        if($modelo !== false){
            if ($modelo['tipo'] != 'glb') {
                $message['modelo_glb'] = "El tipo de archivo debe ser .gbl";
            } else if ($modelo['peso'] > 300) {
                $message['modelo_glb'] = "El modelo debe pesar como máximo 300KB";
            }
        }
		return $message;
	}

    public static function irLogin(){
        header("Location:".$_ENV['BASE_URL']."login/");
    }

    
    public static function irModels(){
        header("Location:".$_ENV['BASE_URL']."models/");
    }
}

?>