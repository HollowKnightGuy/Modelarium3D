<?php

namespace Models;

use DateTime;
use Lib\BaseDatos;
use PDO;
use PDOException;
use Lib\Security;
use Lib\Utils;
use Controllers\ModeloController;


class Peticion
{

    private BaseDatos $conexion;
	private string $id;
	private string $id_modelo;
	private string $id_usuario;
	private string $estado;
	private string $fecha_peticion;
    private ModeloController $mcontroller;


    public function __construct($id, $id_modelo, $id_usuario, $estado, $fecha_peticion)
	{
		$this -> conexion = new BaseDatos();
		$this -> id = $id;
		$this -> id_modelo = $id_modelo;
		$this -> id_usuario = $id_usuario;
		$this -> estado = $estado;
		$this -> fecha_peticion = $fecha_peticion;
        $this -> mcontroller = new ModeloController();

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
	
			$ruta2 = "../public/img/modelRequest/photos/";
			if (file_exists($ruta2) || @mkdir($ruta2)) {
				$origenDocumento = $file['model_photo']['tmp_name'];
				$urlDocumento = $ruta2 . $datos['foto_modelo']['name'];
				@move_uploaded_file($origenDocumento, $urlDocumento);
			}
			$this -> mcontroller -> crear($datos);
			$datos = $this -> mcontroller -> obtenerModelo($datos['id_usuario'], $datos['title']);
			
			$datos -> fecha_peticion = Date("Y-m-d H:i:s");
			$this -> guardarPModelo($datos);

		}else{
			return $validacion;
		}
		
	}

	public function guardarPModelo($datos){

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
				$resultado = $consulta -> fetch(PDO::FETCH_OBJ);
			}
		} catch (PDOException $err) {
			$resultado = false;
		}
		return $resultado;
	
	}


	public function validarPModelo($datosavalidar, $message){	
			$nombreval = "/^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\s]+$/";
			$precioval = "/^(0|[1-9]\d*)(\.\d{2})?$/";
			
			if (empty($datosavalidar['title']) || preg_match($nombreval, $datosavalidar['title']) === 0) {
				$message['nombre'] = "El nombre solo puede contener letras y espacios";
			} else {
				$message['nombre'] = "";
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
	}

?>