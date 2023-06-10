<?php

namespace Models;

use Lib\BaseDatos;
use PDO;
use PDOException;

class Modelo
{

	private string $id;
	private string $titulo;
	private string $descripcion;
	private string $id_usuario;
	private string $archivo_modelo;
	private string $foto_modelo;
	private string $precio;
	private string $privado;
	private string $fecha_subida;
	private string $estado;
	private string $num_likes;
	private string $num_favs;
	private string $num_comment;
	private string $num_complejidad;
	private BaseDatos $conexion;




	public function __construct($id, $titulo, $descripcion, $id_usuario, $archivo_modelo, $foto_modelo, $precio, $fecha_subida, $privado, $estado, $num_likes, $num_favs, $num_comment, $num_complejidad)
	{
		$this->id = $id;
		$this->titulo = $titulo;
		$this->descripcion = $descripcion;
		$this->id_usuario = $id_usuario;
		$this->archivo_modelo = $archivo_modelo;
		$this->foto_modelo = $foto_modelo;
		$this->precio = $precio;
		$this->fecha_subida = $fecha_subida;
		$this->privado = $privado;
		$this->estado = $estado;
		$this->$num_likes = $num_likes;
		$this->$num_favs = $num_favs;
		$this->$num_comment = $num_comment;
		$this->$num_complejidad = $num_complejidad;
		$this->conexion = new BaseDatos();
	}
	
	public static function fromArray(array $data): Modelo
	{
		// DEVUELVE UN OBJETO A PARTIR DE UN ARRAY CON DATOS DE ESTE OBJETO

		$modelo = new Modelo(
			$data['id'] ?? '',
			$data['titulo'] ?? '',
			$data['descripcion'] ?? '',
			$data['id_usuario'] ?? '',
			$data['archivo_modelo'] ?? '',
			$data['foto_modelo'] ?? '',
			$data['precio'] ?? '',
			$data['fecha_subida'] ?? '',
			$data['privado'] ?? '',
			$data['estado'] ?? '',
			$data['num_likes'] ?? '',
			$data['num_favs'] ?? '',
			$data['num_comment'] ?? '',
			$data['nivel_complejidad'] ?? '',
		);

		$modelo->setNum_likes($data['num_likes'] ?? 0);
		$modelo->setNum_favs($data['num_favs'] ?? 0);
		$modelo->setNum_comment($data['num_comment'] ?? 0);
		$modelo->setNum_complejidad($data['nivel_complejidad'] ?? 0);

		return $modelo;
	}


	
	public function obtenerModelo($id_usuario, $titulo)
	{

		$consulta = $this->conexion->prepara("SELECT * FROM modelos 
		WHERE id_usuario = :id_usuario AND titulo = :titulo");

		$consulta->bindParam(':id_usuario', $id_usuario);
		$consulta->bindParam(':titulo', $titulo);


		try {
			$consulta->execute();

			return $consulta->fetch(PDO::FETCH_OBJ);
		} catch (PDOException $err) {
			return false;
		}
	}

	public function obtenerModelosUsuario($id_usuario){
		$consulta = $this->conexion->prepara("SELECT * FROM modelos 
		WHERE id_usuario=:id_usuario AND estado = 'subido'");
		$consulta->bindParam(':id_usuario', $id_usuario);
		try {
			$consulta->execute();
			return $consulta-> fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $err) {
			return false;
		}
	}


	public function guardar($datos)
	{

		$titulo = $datos['title'];
		$precio = $datos['price'];
		$descripcion = $datos['descripcion_modelo'];
		$id_usuario = $datos['id_usuario'];
		$archivo_modelo = $datos['archivo_modelo']['name'];
		$foto_modelo = $datos['foto_modelo']['name'];
		$fecha_subida = Date("Y-m-d H:i:s");
		$consulta = $this->conexion->prepara("INSERT INTO modelos(
			titulo, descripcion, id_usuario, archivo_modelo, foto_modelo, precio, fecha_subida
			) 
			VALUES(
				:titulo,:descripcion,:id_usuario,:archivo_modelo,:foto_modelo,:precio
				)");
		$consulta->bindParam(':titulo', $titulo, PDO::PARAM_STR);
		$consulta->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
		$consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
		$consulta->bindParam(':archivo_modelo', $archivo_modelo, PDO::PARAM_STR);
		$consulta->bindParam(':foto_modelo', $foto_modelo, PDO::PARAM_STR);
		$consulta->bindParam(':precio', $precio, PDO::PARAM_STR);
		$consulta->bindParam(':fecha_subida', $fecha_subida);
		
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

	public function borrar($id)
	{
		try {
			$this->conexion->iniciar_transaccion();
	
			// Verificar si existen filas en la tabla "likes"
			$consultaLikes = $this->conexion->prepara("SELECT * FROM likes WHERE id_modelo = :id");
			$consultaLikes->bindParam(':id', $id);
			$consultaLikes->execute();
	
			// Verificar si existen filas en la tabla "favoritos"
			$consultaFavoritos = $this->conexion->prepara("SELECT * FROM favoritos WHERE id_modelo = :id");
			$consultaFavoritos->bindParam(':id', $id);
			$consultaFavoritos->execute();
	
			// Si no hay filas en ninguna de las tablas, retornar false
			if ($consultaLikes->rowCount() == 0 && $consultaFavoritos->rowCount() == 0) {
				$this->conexion->rollBack();
				return false;
			}
	
			// Borrar las filas de la tabla "likes"
			$borrarLikes = $this->conexion->prepara("DELETE FROM likes WHERE id_modelo = :id");
			$borrarLikes->bindParam(':id', $id);
			$borrarLikes->execute();
	
			// Borrar las filas de la tabla "favoritos"
			$borrarFavoritos = $this->conexion->prepara("DELETE FROM favoritos WHERE id_modelo = :id");
			$borrarFavoritos->bindParam(':id', $id);
			$borrarFavoritos->execute();
	
			// Borrar la fila de la tabla "modelos"
			$borrarModelo = $this->conexion->prepara("DELETE FROM modelos WHERE id = :id");
			$borrarModelo->bindParam(':id', $id);
			$borrarModelo->execute();
	
			$this->conexion->commit();
			return true;
		} catch (PDOException $err) {
			$this->conexion->rollBack();
			echo "Error en la consulta: " . $err->getMessage();
			return false;
		}
	}
	

	public function obtenerModelosPendientes()
	{

		$consulta = $this->conexion->prepara("SELECT m.id, m.titulo, m.descripcion, m.id_usuario, m.archivo_modelo, m.foto_modelo, m.precio, m.fecha_subida, m.privado, m.estado, m.num_likes, m.num_favs, m.num_comment,  m.nivel_complejidad, p.id_modelo, p.tipo
		FROM modelos AS m
		INNER JOIN peticiones AS p ON p.id_modelo = m.id
		WHERE m.estado = 'pendiente'
		AND p.tipo = 'MO';");
		try {
			$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $err) {
			echo "Error en la consulta: " . $err->getMessage();
			return false;
		}
	}

	public function obtenerModelos(int $num_complejidad = null): ?array
	{
		// DEVUELVE UN ARRAY DE OBJETOS MODELO
		if ($num_complejidad === null) {
			$this->conexion->consulta("SELECT * FROM modelos WHERE estado='subido' ORDER BY id ");
			return $this->getAll();
		} else {
			$consulta = $this->conexion->prepara("SELECT * FROM modelos WHERE num_dificultad = :num_complejidad");
			$consulta->bindParam(':num_complejidad', $num_complejidad);
			$consulta->execute();
			return $this->getAll();
		}
	}

	public function getAll(): ?array
	{
		// DEVUELVE UN ARRAY DE MODELOS
		$modelos = [];
		$modelos_datos = $this->conexion->extraer_todos();
		foreach ($modelos_datos as $datos) {
			$modelos[] = Modelo::fromArray($datos);
		}
		return $modelos;
	}

	public function cambiarEstado($id)
	{
		$consulta = $this->conexion->prepara("UPDATE modelos SET estado='subido' WHERE id=:id");
		$consulta->bindParam(':id', $id);
		try {
			$consulta->execute();
			return true;
		} catch (PDOException $err) {
			echo "Error en la consulta: " . $err->getMessage();
			return false;
		}
	}

	public function obtenerModeloPorId($idmodelo)
	{
		$consulta = $this->conexion->prepara("SELECT * FROM modelos WHERE id=:id");
		$consulta->bindParam(':id', $idmodelo);
		try {
			$consulta->execute();
			return $consulta->fetch(PDO::FETCH_OBJ);
		} catch (PDOException $err) {
			echo "Error en la consulta: " . $err->getMessage();
			return false;
		}
	}
	

	public function like($idmodelo){
		$modelo = $this->obtenerModeloPorId($idmodelo);
		$num_likes = $modelo->num_likes;


		if ($num_likes === null) {
			$consulta = $this->conexion->prepara('UPDATE modelos SET num_likes=1 WHERE id=:id');
		} else {
			$consulta = $this->conexion->prepara('UPDATE modelos SET num_likes=num_likes+1 WHERE id=:id');
		}
		$consulta->bindParam(':id', $idmodelo);

		try {
			$consulta->execute();
			return true;
		} catch (PDOException $err) {
			echo "Error en la consulta: " . $err->getMessage();
			return false;
		}
	}

	public function revertirLike($idmodelo){
		$modelo = $this->obtenerModeloPorId($idmodelo);
		$num_likes = $modelo->num_likes;


		if ($num_likes === 1) {
			$consulta = $this->conexion->prepara('UPDATE modelos SET num_likes=NULL WHERE id=:id');
		} else {
			$consulta = $this->conexion->prepara('UPDATE modelos SET num_likes=num_likes-1 WHERE id=:id');
		}
		$consulta->bindParam(':id', $idmodelo);

		try {
			$consulta->execute();
			return true;
		} catch (PDOException $err) {
			echo "Error en la consulta: " . $err->getMessage();
			return false;
		}
	}


	public function favorito($idmodelo){
		$modelo = $this->obtenerModeloPorId($idmodelo);
		$num_favs = $modelo->num_favs;


		if ($num_favs === null) {
			$consulta = $this->conexion->prepara('UPDATE modelos SET num_favs=1 WHERE id=:id');
		} else {
			$consulta = $this->conexion->prepara('UPDATE modelos SET num_favs=num_favs+1 WHERE id=:id');
		}
		$consulta->bindParam(':id', $idmodelo);

		try {
			$consulta->execute();
			return true;
		} catch (PDOException $err) {
			echo "Error en la consulta: " . $err->getMessage();
			return false;
		}
	}

	public function revertirFavorito($idmodelo){
		$modelo = $this->obtenerModeloPorId($idmodelo);
		$num_favs = $modelo->num_favs;


		if ($num_favs === 1) {
			$consulta = $this->conexion->prepara('UPDATE modelos SET num_favs=NULL WHERE id=:id');
		} else {
			$consulta = $this->conexion->prepara('UPDATE modelos SET num_favs=num_favs-1 WHERE id=:id');
		}
		$consulta->bindParam(':id', $idmodelo);

		try {
			$consulta->execute();
			return true;
		} catch (PDOException $err) {
			echo "Error en la consulta: " . $err->getMessage();
			return false;
		}
	}


	public function obtenerModelosBuscar($texto): ?array {
		$texto = strtolower($texto);
		$consult = $this -> conexion -> prepara("SELECT * FROM modelos WHERE LOWER(titulo) LIKE :posib1 OR LOWER(titulo) LIKE :posib2 OR LOWER(titulo) LIKE :posib3");
		$posib1 = "%$texto%";
		$posib2 = "$texto%";
		$posib3 = "%$texto";
		$consult -> bindParam(':posib1', $posib1);
		$consult -> bindParam(':posib2', $posib2);
		$consult -> bindParam(':posib3', $posib3);
		try{
			$consult -> execute();
			$datos = $consult -> fetchAll();
			$modelos = [];
			foreach($datos as $modelo){
				$modelos[] = Modelo::fromArray($modelo);
			}
			return $modelos;
		}catch(PDOException $err){
			// echo "No se ha podido introducir la ruta. Intentelo de nuevo";
			echo $err;
			return false;
		}
	}

	public function cambiarPrivado($id_modelo) {
		try {
			$consulta = $this->conexion->prepara("SELECT privado FROM modelos WHERE id = :id_modelo");
			$consulta->bindParam(':id_modelo', $id_modelo, PDO::PARAM_INT);
			$consulta->execute();
			$resultado = $consulta->fetch();
	
			if ($resultado[0] == false) {
				$consulta = $this->conexion->prepara("UPDATE modelos SET privado = true WHERE id = :id_modelo");
			} else {
				$consulta = $this->conexion->prepara("UPDATE modelos SET privado = false WHERE id = :id_modelo");
			}
	
			$consulta->bindParam(':id_modelo', $id_modelo, PDO::PARAM_INT);
			$consulta->execute();
		} catch (PDOException $err) {
			echo "Error en la consulta: " . $err->getMessage();
			return false;
		}
	}

	public function isPrivado($id_modelo){
		$consulta = $this->conexion->prepara("SELECT privado FROM modelos WHERE id = :id_modelo");
		$consulta->bindParam(':id_modelo', $id_modelo, PDO::PARAM_INT);

		try{
			$consulta->execute();
			$resultado = $consulta->fetch();
			return $resultado[0];
		}catch (PDOException $err) {
			echo "Error en la consulta: " . $err->getMessage();
			return false;
		}
	}

	public function obtenerModelosPrivadosUsuario($id_usuario){

		$consulta = $this->conexion->prepara("SELECT * FROM modelos WHERE id_usuario = :id_usuario AND privado = 1");
		$consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

		try{
			$consulta->execute();
			$resultado = $consulta->fetchAll();
			$modelos = [];
			foreach($resultado as $modelo){
				$modelos[] = Modelo::fromArray($modelo);
			}
			return $modelos;
		}catch (PDOException $err) {
			echo "Error en la consulta: " . $err->getMessage();
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
	 * Get the value of archivo_modelo
	 */
	public function getArchivo_modelo()
	{
		return $this->archivo_modelo;
	}

	/**
	 * Set the value of archivo_modelo
	 *
	 * @return  self
	 */
	public function setArchivo_modelo($archivo_modelo)
	{
		$this->archivo_modelo = $archivo_modelo;

		return $this;
	}

	/**
	 * Get the value of foto_modelo
	 */
	public function getFoto_modelo()
	{
		return $this->foto_modelo;
	}

	/**
	 * Set the value of foto_modelo
	 *
	 * @return  self
	 */
	public function setFoto_modelo($foto_modelo)
	{
		$this->foto_modelo = $foto_modelo;

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


	/**
	 * Get the value of precio
	 */
	public function getPrecio()
	{
		return $this->precio;
	}

	/**
	 * Set the value of precio
	 *
	 * @return  self
	 */
	public function setPrecio($precio)
	{
		$this->precio = $precio;

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

}