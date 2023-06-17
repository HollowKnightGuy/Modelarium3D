<?php

namespace Models;

use Lib\BaseDatos;
use PDO;
use PDOException;
use Lib\Utils;


class Comentario
{

	private string $id;
	private string $id_modelo;
	private string $id_usuario;
	private string $fecha_subida;
	private string $reportado;
	private string $contenido;
    private BaseDatos $conexion;

    public function __construct($id, $id_modelo, $id_usuario, $fecha_subida, $reportado, $contenido){
		$this->id = $id;
		$this->id_modelo = $id_modelo;
		$this->id_usuario = $id_usuario;
		$this->reportado = $reportado;
		$this->fecha_subida = $fecha_subida;
		$this->contenido = $contenido;
		$this->conexion = new BaseDatos();

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

	
	public function comentar($idmodelo, $comentario, $message){
		$validacion = $this -> validarComentario($comentario, $message);
		if($validacion === true){
			$fecha_comentario = Date("Y-m-d H:i:s");
			$consulta = $this -> conexion -> prepara('INSERT INTO comentarios(id_usuario, id_modelo, fecha_subida, contenido) VALUES (:id_usuario, :id_modelo, :fecha_subida, :contenido)');
			$consulta -> bindParam('id_usuario', $_SESSION['identity'] -> id);
			$consulta -> bindParam('id_modelo', $idmodelo);
			$consulta -> bindParam('fecha_subida', $fecha_comentario);
			$consulta -> bindParam('contenido', $comentario);
			try {
				$consulta -> execute();
				return true;
			} catch (PDOException $err) {
				echo 'Error en la consulta'.$err;
				return false;
			}
		}else{
			return $validacion;
		}

	}


	public function obtenerComentarios($idmodelo): ?array
	{
		// DEVUELVE UN ARRAY DE OBJETOS MODELO
			$consulta = $this->conexion->prepara("SELECT * FROM comentarios WHERE id_modelo=:id_modelo ORDER BY id");
			$consulta->bindParam(':id_modelo', $idmodelo);
			try {
				$consulta -> execute();
				$comentarios = $consulta -> fetchAll();
				return $this->getAll($comentarios);
			} catch (PDOException $err) {
				echo 'Error en la consulta'.$err;
				return false;
			}
		}
	

	public function getAll($comentarios): ?array
	{
		// DEVUELVE UN ARRAY DE COMENTARIOS
		$comentarios_datos = [];
		foreach ($comentarios as $datos) {
			$comentarios_datos[] = Comentario::fromArray($datos);
		}
		return $comentarios_datos;
	}

	
	public function validarComentario($comentario, $message){	
		$commentval = "/^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ,.\s]+$/";

		
		//TODO: || strlen(comentario) < 40
		if (empty($comentario) || preg_match($commentval, $comentario) === 0  ) {
			$message['comment'] = "The comment can only contain letters and spaces and a minimum of 20 characters";
		} else {
			$message['comment'] = "";
		}



		if (Utils::comprobarErrores($message)) {
			return true;
		}
		return $message;
	}

	public function cambiarEstadoComentario($reportado, $id_comentario){
        if($reportado){
			$consulta = $this -> conexion -> prepara("UPDATE comentarios SET reportado=1 WHERE id=:id_comentario");
		}else{
			$consulta = $this -> conexion -> prepara("UPDATE comentarios SET reportado=NULL WHERE id=:id_comentario");
		}
		$consulta -> bindParam(":id_comentario", $id_comentario);
		try {
			$consulta -> execute();
			return true;
		} catch (PDOException $err) {
			echo 'Error en la consulta'.$err;
			return false;
		}
    }

	public function obtenerComentarioPorId($id_comentario){
		$consulta = $this -> conexion -> prepara("SELECT * FROM comentarios WHERE id=:id_comentario");
		$consulta -> bindParam(":id_comentario", $id_comentario);
		try {
			$consulta -> execute();
			return $consulta -> fetch(PDO::FETCH_OBJ);
		} catch (PDOException $err) {
			echo 'Error en la consulta'.$err;
			return false;
		}
	}

	public function borrarComentario($id_comentario){
		$consulta = $this -> conexion -> prepara("DELETE FROM comentarios WHERE id=:id_comentario");
		$consulta -> bindParam(":id_comentario", $id_comentario);
		try {
			$consulta -> execute();
			return true;
		} catch (PDOException $err) {
			echo 'Error en la consulta'.$err;
			return false;
		}
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