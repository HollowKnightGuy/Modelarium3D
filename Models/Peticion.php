<?php

namespace Models;

use DateTime;
use Lib\BaseDatos;
use PDO;
use PDOException;
use Lib\Utils;
use Controllers\InterController;


class Peticion
{

    private BaseDatos $conexion;
	private string $id;
	private string $id_modelo;
	private string $id_usuario;
	private string $estado;
	private string $fecha_peticion;
	private InterController $intercontroller;


    public function __construct($id, $id_modelo, $id_usuario, $estado, $fecha_peticion)
	{
		$this -> conexion = new BaseDatos();
		$this -> id = $id;
		$this -> id_modelo = $id_modelo;
		$this -> id_usuario = $id_usuario;
		$this -> estado = $estado;
		$this -> fecha_peticion = $fecha_peticion;
		$this -> intercontroller = new InterController;

    }

	/**
	 * Get the value of id
	 */ 
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set the value of id
	 *
	 * @return  self
	 */ 
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * Get the value of id_modelo
	 */ 
	public function getId_modelo()
	{
		return $this->id_modelo;
	}

	/**
	 * Set the value of id_modelo
	 *
	 * @return  self
	 */ 
	public function setId_modelo($id_modelo)
	{
		$this->id_modelo = $id_modelo;

		return $this;
	}

	/**
	 * Get the value of id_usuario
	 */ 
	public function getId_usuario()
	{
		return $this->id_usuario;
	}

	/**
	 * Set the value of id_usuario
	 *
	 * @return  self
	 */ 
	public function setId_usuario($id_usuario)
	{
		$this->id_usuario = $id_usuario;

		return $this;
	}

	/**
	 * Get the value of estado
	 */ 
	public function getEstado()
	{
		return $this->estado;
	}

	/**
	 * Set the value of estado
	 *
	 * @return  self
	 */ 
	public function setEstado($estado)
	{
		$this->estado = $estado;

		return $this;
	}

	/**
	 * Get the value of fecha_peticion
	 */ 
	public function getFecha_peticion()
	{
		return $this->fecha_peticion;
	}

	/**
	 * Set the value of fecha_peticion
	 *
	 * @return  self
	 */ 
	public function setFecha_peticion($fecha_peticion)
	{
		$this->fecha_peticion = $fecha_peticion;

		return $this;
	}


	public function guardarPeticionModelo($message, $datos, $file, $usuario){
		
		$ruta1 = "../public/3dmodels/";
		$datos['id_usuario'] = $usuario->id;
		$file['model_file']['name']  = uniqid('3dmodel').$file['model_file']['name'];
		$file['model_photo']['name']  = uniqid('imgmodel').$file['model_photo']['name'];
		$datos['archivo_modelo'] = $file['model_file'];
		$datos['foto_modelo'] = $file['model_photo'];
		$validacion = $this -> validarPModelo($datos, $message);
		if($validacion === true){
			if (file_exists($ruta1) || @mkdir($ruta1)) {
				$origenDocumento = $file['model_file']['tmp_name'];
				$urlDocumento = $ruta1 . $datos['archivo_modelo']['name'];
				@move_uploaded_file($origenDocumento, $urlDocumento);
			}
	
			$ruta2 = "../public/img/models/";
			if (file_exists($ruta2) || @mkdir($ruta2)) {
				$origenDocumento = $file['model_photo']['tmp_name'];
				$urlDocumento = $ruta2 . $datos['foto_modelo']['name'];
				@move_uploaded_file($origenDocumento, $urlDocumento);
			}
			$this -> intercontroller -> crearModelo($datos);
			$datos = $this -> intercontroller -> obtenerModelo($datos['id_usuario'], $datos['title']);
			
			$datos -> fecha_peticion = Date("Y-m-d H:i:s");

			$this -> insertarPModelo($datos);

		}else{
			return $validacion;
		}
		
	}

	public function insertarPModelo($datos){

		$id_modelo = $datos -> id;
		$id_usuario = $datos -> id_usuario;
		$estado = $datos -> estado;
		$fecha_peticion = $datos -> fecha_peticion;
		$tipo = 'MO';


		$consulta = $this -> conexion -> prepara("INSERT INTO peticiones(
			id_modelo, estado, id_usuario, tipo, fecha_peticion
			) 
			VALUES(
				:id_modelo,:estado,:id_usuario,:tipo,:fecha_peticion
				)");
		$consulta -> bindParam(':id_modelo', $id_modelo, PDO::PARAM_STR);
		$consulta -> bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
		$consulta -> bindParam(':estado', $estado, PDO::PARAM_STR);
		$consulta -> bindParam(':tipo', $tipo, PDO::PARAM_STR);
		$consulta -> bindParam(':fecha_peticion', $fecha_peticion, PDO::PARAM_STR);

		try {
			$consulta -> execute();
			if ($consulta && $consulta -> rowCount() == 1) {
				return $consulta -> fetch(PDO::FETCH_OBJ);
			}
		} catch (PDOException $err) {
			return false;
		}
	}

	public function guardarPeticionCreador($message, $datos, $usuario){

		$ruta1 = "../public/3dmodels/";
		$datos['id_usuario'] = $usuario -> id;
		$datos['id_modelo'] = $this -> intercontroller -> obtenerModelo($datos['id_usuario'], $datos['title']) -> id;
		$datos['fecha_peticion'] = Date("Y-m-d H:i:s");
		$archivo_modelo = $datos['archivo_modelo'];
		$foto_modelo = $datos['foto_modelo'];
		$validacion = $this -> validarPCreador($datos, $message);
		if($validacion != true){
			$validacionFinal = $this -> validarPModelo($datos, $validacion);
		}else{
			$validacionFinal = $this -> validarPModelo($datos, $message);
		}
		if($validacionFinal === true){

			if (file_exists($ruta1) || @mkdir($ruta1)){
				$origenDocumento = $archivo_modelo['tmp_name'];
				$urlDocumento = $ruta1 . $archivo_modelo['name'];
				@move_uploaded_file($origenDocumento, $urlDocumento);
			}
			
			$ruta2 = "../public/img/models/";
			if (file_exists($ruta2) || @mkdir($ruta2)) {
				$origenDocumento = $foto_modelo['tmp_name'];
				$urlDocumento = $ruta2 . $foto_modelo['name'];
				@move_uploaded_file($origenDocumento, $urlDocumento);
			}
			
			$this -> insertarPCreador($datos);
		}else{
			return $validacionFinal;
		}

	}

	public function insertarPCreador($datos){

		$id_modelo = $datos['id_modelo'];
		$id_usuario = $datos['id_usuario'];
		$estado = 'pendiente';
		$fecha_peticion = $datos['fecha_peticion'];
		$tipo = 'CR';


		$consulta = $this -> conexion -> prepara("INSERT INTO peticiones(
			id_modelo, estado, id_usuario, tipo, fecha_peticion
			) 
			VALUES(
				:id_modelo,:estado,:id_usuario,:tipo,:fecha_peticion
				)");
		$consulta -> bindParam(':id_modelo', $id_modelo, PDO::PARAM_STR);
		$consulta -> bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
		$consulta -> bindParam(':estado', $estado, PDO::PARAM_STR);
		$consulta -> bindParam(':tipo', $tipo, PDO::PARAM_STR);
		$consulta -> bindParam(':fecha_peticion', $fecha_peticion, PDO::PARAM_STR);

		try {
			$consulta -> execute();
			if ($consulta && $consulta -> rowCount() == 1) {
				return $consulta -> fetch(PDO::FETCH_OBJ);
			}
		} catch (PDOException $err) {
			return false;
		}
	}

	public function obtenerCreatorsPendientes(){
		$consulta = $this->conexion->prepara("SELECT * FROM peticiones WHERE estado = 'pendiente' AND tipo = 'CR'");
		try {
			$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $err) {
			echo "Error en la consulta: " . $err->getMessage();
			return false;
		}
	}

	public function obtenerPeticionCreador($id){

		$consulta = $this->conexion->prepara("SELECT * FROM peticiones WHERE id = $id");
		try {
			$consulta->execute();
			$id_modelo = $consulta->fetchAll(PDO::FETCH_OBJ)[0]->id_modelo;
			$consulta = $this -> conexion -> prepara ("SELECT * FROM modelos WHERE id = $id_modelo");
			$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $err) {
			echo "Error en la consulta: " . $err->getMessage();
			return false;
		}

		//está devolviendo un objeto modelo con todos los datos de el modelo de esa peticion $id


	}

	public function validarPModelo($datosavalidar, $message){	
			$nombreval = "/^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\s]+$/";
			$precioval = "/^(0|[1-9]\d*)(\.\d{2})?$/";
			
			if (empty($datosavalidar['title']) || preg_match($nombreval, $datosavalidar['title']) === 0) {
				$message['titulo'] = "El titulo solo puede contener letras y espacios";
			} else {
				$message['titulo'] = "";
			}
			
			if (empty($datosavalidar['price']) || !preg_match($precioval, $datosavalidar['price'])) {
				$message['precio'] = "El precio debe contener solo numeros (Ex: XX.XX)";
			} else {
				$message['precio'] = "";
			}
	
			if (empty($datosavalidar['desc']) && preg_match($nombreval, $datosavalidar['desc']) === 0) {
				$message['descripcion'] = "La descripción solo puede contener letras y espacios";
			} else {
				$message['descripcion'] = "";
			}

			$modelos_usuario = $this -> intercontroller -> obtenerModelosUsuario($_SESSION['identity'] -> id);
			foreach($modelos_usuario as $modelo){
				if(strtolower($modelo -> titulo) === strtolower($datosavalidar['title'])){
					$message['titulo'] = "Ya tienes un modelo que se llama así";
				}
			}
			$archivo_modelo = $datosavalidar['archivo_modelo'];
			$message = Utils::validarArchivoModelo($archivo_modelo, $message);

	
			$foto_modelo = $datosavalidar['foto_modelo'];
			$message = Utils::validarImagenModelo($foto_modelo, $message);
	
	
			if ($this->comprobarErrores($message)) {
				return true;
			}
			return $message;
		}


		public function comprobarErrores($lista)
		{
			foreach ($lista as $error) {
				if (!empty($error)) {
					return false;
				}
			}
			return true;
		}

		public function validarPCreador($datosavalidar, $message){	
			$nombreval = "/^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\s]+$/";
			$emailval = "/^[A-z0-9\\.-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9-]+)*\\.([A-z]{2,6})$/";
			
			if (empty($datosavalidar['email']) || preg_match($emailval, $datosavalidar['email']) === 0) {
				$message['email'] = "Correo no válido";
			} else {
				$message['email'] = "";
			}

			if (empty($datosavalidar['desc']) && preg_match($nombreval, $datosavalidar['desc']) === 0) {
				$message['desc'] = "La descripción solo puede contener letras y espacios";
			} else {
				$message['desc'] = "";
			}
	
			if ($this->comprobarErrores($message)) {
				return true;
			}
			return $message;
		}
	}


?>