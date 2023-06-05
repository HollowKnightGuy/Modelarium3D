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

    public static function isAdmin():bool{
        // COMPRUEBA SI LA SESSION ESTA INICIADA POR UN ADMIN
        if(isset($_SESSION['admin']) && $_SESSION['admin'] === true){
            return true;
        }
        else{
            return false;
        }
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
            }else if ($banner['peso'] > 150) {
                $message['imagenbanner'] = "El banner como máximo debe pesar 150KB";
            }
        }

		return $message;
	}
}

?>