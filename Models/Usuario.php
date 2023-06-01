<?php 

namespace Models;

use DateTime;
use Lib\BaseDatos;
use PDO;
use PDOException;

class Usuario{

    private string $id;
    private string $nombre;
    private string $email;
	private string $password;
    private string $rol;
    private $foto_perfil;
    private $banner;
    private string $descripcion;
    private string $descuento;
    private string $fecha_creacion;
    private string $num_modelos;


    private BaseDatos $conexion;

    public function __construct($id, $nombre, $email, $password, $rol, $foto_perfil, $descripcion, $descuento, $fecha_creacion, $num_modelos){
		$this -> conexion = new BaseDatos();
		$this -> id = $id;
		$this -> nombre = $nombre;
		$this -> email = $email;
		$this -> password = $password;
		$this -> rol = $rol;
		$this -> foto_perfil = $foto_perfil;
		$this -> descripcion = $descripcion;
		$this -> descuento = $descuento;
		$this -> fecha_creacion = $fecha_creacion;
		$this -> num_modelos = $num_modelos;
    }



	public function getId(): string {
		return $this->id;
	}


	public function setId(string $id): self {
		$this->id = $id;
		return $this;
	}


	public function getNombre(): string {
		return $this->nombre;
	}


	public function setNombre(string $nombre): self {
		$this->nombre = $nombre;
		return $this;
	}
	

	public function getEmail(): string {
		return $this->email;
	}
	

	public function setEmail(string $email): self {
		$this->email = $email;
		return $this;
	}
	

	public function getPassword()
	{
		return $this->password;
	}


	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}


	public function getRol()
	{
		return $this->rol;
	}


	public function setRol($rol)
	{
		$this->rol = $rol;

		return $this;
	}


	public function getFoto_perfil()
	{
		return $this->foto_perfil;
	}


	public function setFoto_perfil($foto_perfil)
	{
		$this->foto_perfil = $foto_perfil;

		return $this;
	}

	public function getDescripcion()
	{
		return $this->descripcion;
	}


	public function setDescripcion($descripcion)
	{
		$this->descripcion = $descripcion;

		return $this;
	}


	/**
	 * Get the value of descuento
	 */ 
	public function getDescuento()
	{
		return $this->descuento;
	}

	/**
	 * Set the value of descuento
	 *
	 * @return  self
	 */ 
	public function setDescuento($descuento)
	{
		$this->descuento = $descuento;

		return $this;
	}


	public function getFecha_creacion()
	{
		return $this->fecha_creacion;
	}

 
	public function setFecha_creacion($fecha_creacion)
	{
		$this->fecha_creacion = $fecha_creacion;

		return $this;
	}


	public function getNum_modelos()
	{
		return $this->num_modelos;
	}


	public function setNum_modelos($num_modelos)
	{
		$this->num_modelos = $num_modelos;

		return $this;
	}



	

	public static function fromArray(array $data):Usuario{
		// DEVUELVE UN OBJETO A PARTIR DE UN ARRAY CON DATOS DE ESTE OBJETO
		return new Usuario(
			$data['id'] ?? '',
			$data['username'] ?? '',
			$data['email'] ?? '',
			$data['pass'] ?? '',
			$data['rol'] ?? '',
			$data['file'] ?? '',
			$data['desc'] ?? '',
			$data['descuento'] ?? '',
			$data['fecha_creación'] ?? '',
			$data['num_modelos'] ?? '',
		);
	}



	//Comprueba que el correo no existe ya en la base de datos
	public function buscaMail($email){
		// COMPRUEBA SI UN EMAIL ESTA EN USO (NO USADO)
		$result = false;
		$cons = $this -> conexion -> prepara("SELECT * FROM usuarios WHERE email = ?");
		$cons -> bindParam(1, $email);
		try{
			$cons -> execute();
			if($cons && $cons -> rowCount() == 1){
				$result = $cons -> fetch(PDO::FETCH_OBJ);
			}
		} catch(PDOException $err){
			$result = false;
		}
		return $result;
	}


	public function login(): bool|object {
		// LLEVA A CABO LA VALIDACION PARA QUE EL LOGIN SE PROCESE
		
		$result = false;
		$email = $this -> email;
		$password = $this -> password;
		
		$usuario = $this -> buscaMail($email);
		if ($usuario != false) {
			$verify = password_verify($password, $usuario -> password);

			if ($verify) {
				$result = $usuario;
			}
		}
		return $result;
	}



	//Obtiene la contraseña desde la base de datos de un usuario con el $email que le pasamos
	public function obtenerPassword($email){

		$statement = "SELECT password FROM usuarios WHERE email = '$email'";

		try{
			$statement = $this -> conexion -> consulta($statement);    
			return $statement -> fetchAll(\PDO::FETCH_ASSOC);
		}catch(\PDOException $e){
			exit($e -> getMessage());
		}
		
	}

	public function comprobarErrores($lista){
		foreach($lista as $error){
			if(!empty($error)){
				return false;
			}
		}
		return true;
	}
	

	//Crea un usuario en la base de datos con los datos que le pasamos
	public function save($message, $propiedadesImg):array|bool{
		$email = $this -> email;
		if($this -> buscaMail($email) != false){
			$message["generico"] = 'Este correo ya está registrado';
		}else{
			$id = NULL;
			$nombre = $this -> nombre;
			$password = $this -> password;
			$rol = 'ROLE_USER';
			$foto_perfil = $this -> foto_perfil['name'];
			$descripcion = $this -> descripcion;
			$fecha_creacion = date('Y-m-d H:i:s');
			$datos_validar = ['nombre' => $nombre,
							  'email' => $email,
			 				  'password' => $password,
			  				  'descripcion' => $descripcion,
							  'imgProps' => $propiedadesImg];
			$validacion = $this -> validarDatosRegister($datos_validar, $message);
			if($validacion === true){
				// INSERTA UN USUARIO EN LA BASE DE DATOS
				$password = password_hash($this -> password, PASSWORD_BCRYPT, ['cost' => 4]);
				$ins = $this -> conexion -> prepara("INSERT INTO usuarios(
					id, nombre, email, password, rol, descripcion, fecha_creacion, foto_perfil
					) 
					VALUES(
						:id,:nombre,:email,:password,:rol,:descripcion,:fecha_creacion, :foto_perfil
						)");
				$ins -> bindParam('id',$id);
				$ins -> bindParam(':nombre',$nombre,PDO::PARAM_STR);
				$ins -> bindParam(':email',$email,PDO::PARAM_STR);
				$ins -> bindParam(':password',$password,PDO::PARAM_STR);
				$ins -> bindParam(':rol',$rol,PDO::PARAM_STR);
				$ins -> bindParam(':foto_perfil',$foto_perfil,PDO::PARAM_STR);
				$ins -> bindParam(':descripcion',$descripcion,PDO::PARAM_STR);
				$ins -> bindParam(':fecha_creacion',$fecha_creacion,PDO::PARAM_STR);
		
				try{
					
					$ins -> execute();
					if(file_exists("../public/img/user/profilephoto/") || @mkdir("../public/img/user/profilephoto/")){
						$origenDocumento = $this-> foto_perfil['tmp_name'];
						$urlDocumento = "../public/img/user/profilephoto/".$foto_perfil;
						@move_uploaded_file($origenDocumento, $urlDocumento);
						}
					return true;
				}catch(PDOException $err){
					return false;
				}
			}else{
				return $validacion;
			}
	
		}


		}

	

    //Valida todos los datos que debe de tener un usuario en el formulario de registro, devuelve true si está bien o un string con el mensaje de error
	public function validarDatosRegister($datos_usuario, $message):array|bool{

		$nombreval = "/^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\s]+$/";
		$emailval = "/^[A-z0-9\\.-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9-]+)*\\.([A-z]{2,6})$/";
		$passwval = "/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{6,14}$/";

		if(empty($datos_usuario['nombre']) || preg_match($nombreval, $datos_usuario['nombre']) === 0){
			$message['nombre'] = "El nombre solo puede contener letras y espacios";
		}else{$message['nombre'] = "";}

		if(empty($datos_usuario['descripcion']) || preg_match($nombreval, $datos_usuario['descripcion']) === 0){
			$message['descripcion'] = "La descripción solo puede contener letras y espacios";
		}else{$message['descripcion'] = "";}

		if(!preg_match($emailval, $datos_usuario['email'])){
			$message['email'] = "Correo no válido";
		}else{$message['email'] = "";}

		if(!preg_match($passwval,$datos_usuario['password'])){
			$message['password'] = "La contraseña debe medir entre 6 y 14 carácteres, al menos tener un número, una minúscula y una mayúscula";
		}else{$message['password'] = "";}

		$imgProps = $datos_usuario['imgProps'];
		if($imgProps['tipo'] != 'jpg' && $imgProps['tipo'] != 'jpeg' && $imgProps['tipo'] != 'png'){
			$message['imagen'] = "El tipo de la imagen debe ser jpg/jpeg/png";
		}else if($imgProps['ancho'] != $imgProps['alto']){
			$message['imagen'] = "La imagen debe ser cuadrada";
		}else if($imgProps['peso'] > 200){
			$message['imagen'] = "Como máximo debe pesar 75KB";
		}

		if($this -> comprobarErrores($message)){
			return true;
		}
		return $message;

	}




    //Valida todos los datos que debe de tener un usuario en el formulario de login, devuelve true si está bien o un string con el mensaje de error
	public function validarDatosLogin($datos_usuario):string|bool{

		$emailval = "/^[A-z0-9\\.-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9-]+)*\\.([A-z]{2,6})$/";
		$passwval = "/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{6,14}$/";

		if(!preg_match($emailval, $datos_usuario['email'])){
			$message = "Correo no valido";
		}

		else if(!preg_match($passwval,$datos_usuario['passw'])){
			$message = "La contrasena debe medir entre 6 y 14 caracteres, al menos tener un numero, al menos una minuscula y al menos una mayuscula";
		}

		if(isset($message)){
			return $message;
		}else{
			return true;
		}

	}




	public function getall(){
		$statement = "SELECT * FROM usuarios ";

		try{
			$statement = $this -> conexion -> consulta($statement);    
			return $statement -> fetchAll(\PDO::FETCH_ASSOC);
		}catch(\PDOException $e){
			exit($e -> getMessage());
		}
	}

}

?>