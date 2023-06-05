<?php

namespace Models;

use DateTime;
use Lib\BaseDatos;
use PDO;
use PDOException;
use Lib\Security;
use Lib\Utils;

class Peticion
{

    private BaseDatos $conexion;
	private string $id;
	private string $id_modelo;
	private string $id_usuario;
	private string $estado;
	private string $fecha_peticion;

    public function __construct($id, $id_modelo, $id_usuario, $estado, $fecha_peticion)
	{
		$this->conexion = new BaseDatos();
		$this->id = $id;
		$this->id_modelo = $id_modelo;
		$this->id_usuario = $id_usuario;
		$this->estado = $estado;
		$this->fecha_peticion = $fecha_peticion;
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


		var_dump($datos, $file, $usuario);
		die;
	}
}

?>