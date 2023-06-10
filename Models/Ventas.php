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

	public function comprar($modelo, $id_usuario_comprador){

		$id_modelo = $modelo -> id;
		$id_usuario_creador = $modelo -> id_usuario;
		$precio_venta = $modelo -> precio;
		$fecha_venta = date('Y-m-d H:i:s');

		$consulta = $this->conexion->prepara("INSERT INTO ventas(
			id_usuario_creador, id_usuario_comprador, id_modelo, fecha_venta, precio_venta
			) 
			VALUES(
				:id_usuario_creador,:id_usuario_comprador,:id_modelo,:fecha_venta,:precio_venta
				)");
		$consulta->bindParam(':id_usuario_creador', $id_usuario_creador, PDO::PARAM_INT);
		$consulta->bindParam(':id_usuario_comprador', $id_usuario_comprador, PDO::PARAM_INT);
		$consulta->bindParam(':id_modelo', $id_modelo, PDO::PARAM_INT);
		$consulta->bindParam(':fecha_venta', $fecha_venta, PDO::PARAM_STR);
		$consulta->bindParam(':precio_venta', $precio_venta, PDO::PARAM_STR);
		
		try {
			$consulta->execute();
			
			if ($consulta && $consulta->rowCount() == 1) {
				return $consulta->fetch(PDO::FETCH_OBJ);
			}
		} catch (PDOException $err) {
			echo "Error en la consulta".$err;
			return false;
		}
	}

	public function comprobarVenta($id_usuario, $id_modelo){
		
		$result = false;
		$consulta = $this->conexion->prepara("SELECT * FROM ventas WHERE id_usuario_comprador = :id_usuario AND id_modelo = :id_modelo");
		
		$consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
		$consulta->bindParam(':id_modelo', $id_modelo, PDO::PARAM_INT);


		try {
			$consulta->execute();
			$result = $consulta->fetch(PDO::FETCH_OBJ);
		
			if ($result) {
				$result = true;
			} else {
				$result = false;
			}
		} catch (PDOException $err) {
			$result = false;
		}
		return $result;
	}

	public function obtenerVentasUsuario($id_usuario_creador){
		$consulta = $this->conexion->prepara("SELECT id_usuario_creador, SUM(precio_venta) AS total_ventas FROM ventas WHERE id_usuario_creador = :id_usuario_creador GROUP BY id_usuario_creador");
		$consulta->bindParam(':id_usuario_creador', $id_usuario_creador, PDO::PARAM_INT);
		
		try {
			$consulta->execute();
			$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
			return $resultados;
		} catch (PDOException $err) {
			echo "Error en la consulta: " . $err->getMessage();
			return false;
		}
		
	}

	public function obtenerComprasUsuario($id_usuario){
		$consulta = $this ->conexion->prepara('SELECT m.* FROM modelos m INNER JOIN ventas v ON m.id = v.id_modelo WHERE v.id_usuario_comprador = :id_usuario');

		$consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
		$consulta->execute();
	
		$resultados = $consulta->fetchAll(PDO::FETCH_OBJ);

		return $resultados;
	}



    
}

?>