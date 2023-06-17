<?php

namespace Models;

use Lib\BaseDatos;

use Lib\Utils;

class Contacto
{


	private Utils $utils;
	private BaseDatos $conexion;

	public function __construct()
	{

		$this->utils = new Utils();
		$this->conexion = new BaseDatos();
	}

    public function contacto($datos, $message){
        $validacion = $this -> validarDatosContacto($datos, $message);
        return $validacion;
    }


	public function validarDatosContacto($datos_usuario, $message): array|bool
	{

		$nombreval = "/^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\s]+$/";
		$emailval = "/^[A-z0-9\\.-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9-]+)*\\.([A-z]{2,6})$/";
		if (empty($datos_usuario['name']) || preg_match($nombreval, $datos_usuario['name']) === 0) {
			$message['nombre_email'] = "Invalid name";
		} else {
			$message['nombre_email'] = "";
		}
		
		if (empty($datos_usuario['desc']) || preg_match($nombreval, $datos_usuario['desc']) === 0) {
			$message['desc'] = "Invalid description";
		} else {
			$message['desc'] = "";
		}
		
		if (empty($datos_usuario['email']) || !preg_match($emailval, $datos_usuario['email'])) {
			$message['nombre_email'] = "Invalid email";
		} else {
			if(empty($message['nombre_email'])){
				$message['nombre_email'] = "";
			}
		}


		if (Utils::comprobarErrores($message)) {
			return true;
		}
		return $message;
	}








}