<?php

namespace Models;

use DateTime;
use Lib\BaseDatos;
use PDO;
use PDOException;
use Lib\Security;
use Lib\Utils;
Use Models\Modelo;


class Peticion
{

    private BaseDatos $conexion;
	private string $id;
	private string $id_modelo;
	private string $id_usuario;
	private string $estado;
	private string $fecha_peticion;

    private Modelo $modelo;


    public function __construct($id, $id_modelo, $id_usuario, $estado, $fecha_peticion)
	{
		$this->conexion = new BaseDatos();
		$this->id = $id;
		$this->id_modelo = $id_modelo;
		$this->id_usuario = $id_usuario;
		$this->estado = $estado;
		$this->fecha_peticion = $fecha_peticion;

        $this -> modelo = new Modelo(0,'','','','','','','','','','','');

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


	public function guardarPeticion($datos, $file, $usuario){

		$datos['id_usuario'] = $usuario->id;
		$datos['fecha_subida'] = Date("Y-m-d H:i:s");
		$datos['archivo_modelo'] = $file['data']['name']['file'];
		$datos['foto_modelo'] = $file['data']['name']['file_photo'];

		if (file_exists("../public/img/modelRequest/models/") || @mkdir("../public/img/modelRequest/models/")) {
			$origenDocumento = $file['data']['tmp_name']['file'];
			$urlDocumento = "../public/img/modelRequest/models/" . $datos['archivo_modelo'];
			@move_uploaded_file($origenDocumento, $urlDocumento);
		}

		if (file_exists("../public/img/modelRequest/photos/") || @mkdir("../public/img/modelRequest/photos/")) {
			$origenDocumento = $file['data']['tmp_name']['file_photo'];
			$urlDocumento = "../public/img/modelRequest/photos/" . $datos['foto_modelo'];
			@move_uploaded_file($origenDocumento, $urlDocumento);
		}
		
		// Funciona la subida a la Base de datos
		$resultado = $this -> modelo -> guardar($datos);
		var_dump($resultado);die;
		$this -> guardar($datos);


		//TODO: Recoger también el archivo y guardarlo en una carpeta de peticiones

	}

	public function guardar($datos){

		$id_modelo = $datos['id_modelo'];
		$id_usuario = $datos['id_usuario'];
		$estado = $datos['estado'];
		$fecha_peticion = $datos['fecha_peticion'];


		$consulta = $this->conexion->prepara("INSERT INTO peticiones(
			id_modelo, estado, id_usuario, precio, fecha_peticion
			) 
			VALUES(
				:id_modelo,:estado,:id_usuario,:precio,:fecha_peticion
				)");
		$consulta->bindParam(':id_modelo', $id_modelo, PDO::PARAM_STR);
		$consulta->bindParam(':estado', $estado, PDO::PARAM_STR);
		$consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
		$consulta->bindParam(':fecha_peticion', $fecha_peticion, PDO::PARAM_STR);

		try {
			$consulta->execute();
			if ($consulta && $consulta->rowCount() == 1) {
				$resultado = $consulta->fetch(PDO::FETCH_OBJ);
			}
		} catch (PDOException $err) {
			$resultado = false;
		}
		return $resultado;
	
	}
	

}

?>