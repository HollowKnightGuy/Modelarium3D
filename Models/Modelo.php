<?php

namespace Models;

use Lib\BaseDatos;
use PDO;
use PDOException;
use Lib\Security;
use Lib\Utils;

class Modelo
{

    private BaseDatos $conexion;
	private string $id;
	private string $titulo;
	private string $id_usuario;
	private string $descripcion;
	private string $fecha_subida;
	private string $privado;
	private string $num_likes;
	private string $num_favs;
	private string $num_comment;
	private string $num_complejidad;




    public function __construct($id, $titulo, $id_usuario, $descripcion, $fecha_subida, $privado, $num_likes, $num_favs, $num_comment, $num_complejidad)
	{
		$this -> conexion = new BaseDatos();
		$this -> id = $id;
		$this -> titulo = $titulo;
		$this -> id_usuario = $id_usuario;
		$this -> descripcion = $descripcion;
		$this -> id_usuario = $id_usuario;
		$this -> fecha_subida = $fecha_subida;
		$this -> privado = $privado;
        $this -> $num_likes = $num_likes;
        $this -> $num_favs = $num_favs;
        $this -> $num_comment = $num_comment;
        $this -> $num_complejidad = $num_complejidad;


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
	 * Get the value of titulo
	 */ 
	public function getTitulo()
	{
		return $this->titulo;
	}

	/**
	 * Set the value of titulo
	 *
	 * @return  self
	 */ 
	public function setTitulo($titulo)
	{
		$this->titulo = $titulo;

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
	 * Get the value of descripcion
	 */ 
	public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	 * Set the value of descripcion
	 *
	 * @return  self
	 */ 
	public function setDescripcion($descripcion)
	{
		$this->descripcion = $descripcion;

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
	 * Get the value of privado
	 */ 
	public function getPrivado()
	{
		return $this->privado;
	}

	/**
	 * Set the value of privado
	 *
	 * @return  self
	 */ 
	public function setPrivado($privado)
	{
		$this->privado = $privado;

		return $this;
	}

	/**
	 * Get the value of num_likes
	 */ 
	public function getNum_likes()
	{
		return $this->num_likes;
	}

	/**
	 * Set the value of num_likes
	 *
	 * @return  self
	 */ 
	public function setNum_likes($num_likes)
	{
		$this->num_likes = $num_likes;

		return $this;
	}

    /**
     * Get the value of num_complejidad
     */ 
    public function getNum_complejidad()
    {
        return $this->num_complejidad;
    }

    /**
     * Set the value of num_complejidad
     *
     * @return  self
     */ 
    public function setNum_complejidad($num_complejidad)
    {
        $this->num_complejidad = $num_complejidad;

        return $this;
    }

    /**
     * Get the value of num_favs
     */ 
    public function getNum_favs()
    {
        return $this->num_favs;
    }

    /**
     * Set the value of num_favs
     *
     * @return  self
     */ 
    public function setNum_favs($num_favs)
    {
        $this->num_favs = $num_favs;

        return $this;
    }

    /**
     * Get the value of num_comment
     */ 
    public function getNum_comment()
    {
        return $this->num_comment;
    }

    /**
     * Set the value of num_comment
     *
     * @return  self
     */ 
    public function setNum_comment($num_comment)
    {
        $this->num_comment = $num_comment;

        return $this;
    }


	public function save($data){

		$id = $data['id'];
		$titulo = $data['titulo'];
		$descripcion = $data['descripcion'];
		$id_usuario = $data['id_usuario'];
		$precio = $data['precio'];
		$fecha_subida = $data['fecha_subida'];
		$fecha_creacion = $data['fecha_creacion'];


		$consulta = $this->conexion->prepara("INSERT INTO modelos(
			id, titulo, descripcion, id_usuario, precio, fecha_subida, fecha_creacion,
			) 
			VALUES(
				:id,:titulo,:descripcion,:id_usuario,:precio,:fecha_subida,:fecha_creacion, 
				)");
		$consulta->bindParam('id', $id);
		$consulta->bindParam(':titulo', $titulo, PDO::PARAM_STR);
		$consulta->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
		$consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
		$consulta->bindParam(':precio', $precio, PDO::PARAM_STR);
		$consulta->bindParam(':fecha_subida', $fecha_subida, PDO::PARAM_STR);
		$consulta->bindParam(':fecha_creacion', $fecha_creacion, PDO::PARAM_STR);

	}
}
