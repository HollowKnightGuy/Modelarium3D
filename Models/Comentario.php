<?php

namespace Models;

use Lib\BaseDatos;
use PDO;
use PDOException;
use Lib\Security;
use Lib\Utils;


class Comentario
{

    private BaseDatos $conexion;
	private string $id;
	private string $id_modelo;
	private string $id_usuario;
	private string $fecha_subida;
	private string $reportado;
	private string $contenido;

    public function __construct($id, $id_modelo, $id_usuario, $fecha_subida, $reportado, $contenido){
		$this->conexion = new BaseDatos();
		$this->id = $id;
		$this->id_modelo = $id_modelo;
		$this->id_usuario = $id_usuario;
		$this->reportado = $reportado;
		$this->fecha_subida = $fecha_subida;

    }

	public static function fromArray(array $data): Comentario
	{
		// DEVUELVE UN OBJETO A PARTIR DE UN ARRAY CON DATOS DE ESTE OBJETO
		return new Comentario(
			$data['id'] ?? '',
			$data['id_modelo'] ?? '',
			$data['id_usuario'] ?? '',
			$data['fecha_subida'] ?? '',
			$data['reportado'] ?? '',
			$data['contenido'] ?? '',
		);
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
	 * Get the value of fecha_subida
	 */ 
	public function getFecha_subida()
	{
		return $this->fecha_subida;
	}
	
	/**
	 * Set the value of fecha_subida
	 *
	 * @return  self
	 */ 
	public function setFecha_subida($fecha_subida)
	{
		$this->fecha_subida = $fecha_subida;
		
		return $this;
	}
	
	/**
	 * Get the value of reportado
	 */ 
	public function getReportado()
	{
		return $this->reportado;
	}
	
	/**
	 * Set the value of reportado
	 *
	 * @return  self
	 */ 
	public function setReportado($reportado)
	{
		$this->reportado = $reportado;
		
		return $this;
	}
	
	/**
	 * Get the value of contenido
	 */ 
	public function getContenido()
	{
		return $this->contenido;
	}
	
	/**
	 * Set the value of contenido
	 *
	 * @return  self
	 */ 
	public function setContenido($contenido)
	{
		$this->contenido = $contenido;
		
		return $this;
	}
	
}
?>