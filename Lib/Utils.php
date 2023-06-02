<?php

namespace Lib;

class Utils{
    public static function deleteSession($name){
        // BORRA LA SESSION 
        if(isset($_SESSION[$name])){
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }

        return $name;
    }

    public static function isAdmin(){
        // COMPRUEBA SI LA SESSION ESTA INICIADA POR UN ADMIN
        if(isset($_SESSION['admin']) && $_SESSION['admin'] === true){
            return true;
        }
        else{
            return false;
        }
    }

    public static function isLogged(){
        // COMPRUEBA SI HAY ALGUIEN LOGUEADO
        if(isset($_SESSION['identity'])){
            return true;
        }
        else{
            return false;
        }
    }
}

?>