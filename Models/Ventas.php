<?php

namespace Models;

use Lib\BaseDatos;
use PDO;
use PDOException;
use Lib\Security;
use Lib\Utils;

class Ventas
{

	private BaseDatos $conexion;
	private string $id;
	private string $id_usuario_creador;
	private string $id_usuario_comprador;
	private string $id_modelo;
	private string $fecha_venta;
	private string $precio_venta;


	public function __construct($id, $id_usuario_creador, $id_usuario_comprador, $id_modelo, $fecha_venta, $precio_venta)
	{
		$this->conexion = new BaseDatos();
		$this->id = $id;
		$this->id_usuario_creador = $id_usuario_creador;
		$this->id_usuario_comprador = $id_usuario_comprador;
		$this->id_modelo = $id_modelo;
		$this->fecha_venta = $fecha_venta;
		$this->precio_venta = $precio_venta;
		
    }

    
}

?>