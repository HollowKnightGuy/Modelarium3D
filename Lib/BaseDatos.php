<?php

namespace Lib;
use PDO;
use PDOException;

class BaseDatos {
    public PDO $conexion;

    private mixed $resultado;
    private string $servidor;
    private string $usuario;
    private string $pass;
    private string $base_datos;

    function __construct() {
        $this->servidor = $_ENV['DB_HOST'];
        $this->usuario = $_ENV['DB_USER'];
        $this->pass = $_ENV['DB_PASS'];
        $this->base_datos = $_ENV['DB_DATABASE'];
        
        $this->conexion = $this->conectar();
    }
    private function conectar(): PDO {

        try{

            $opciones = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::MYSQL_ATTR_FOUND_ROWS => true
            );

            $conexion = new PDO("mysql:host={$this->servidor};dbname={$this->base_datos};charset=utf8",$this->usuario, $this->pass, $opciones);

            return $conexion;

        }catch(PDOException $e){

            echo 'Ha surgido Un error y no se puede cOnectar a la base de datOs. Detalle: '.$e->getMessage();
            exit;
        }
    }

    public function iniciar_transaccion(){
        $this -> conexion -> beginTransaction();
    }
    public function rollback(){
        $this -> conexion -> rollBack();
    }
    public function commit(){
        $this -> conexion -> commit();
    }

    public function consulta(string $consultaSQL){
        $this->resultado=$this->conexion->query($consultaSQL);
        return $this -> resultado;
    }

    public function extraer_registro():mixed{
        return ($fila=$this->resultado->fetch(PDO::FETCH_ASSOC))?$fila:false;
    }

    public function extraer_todos():array{
        return $this->resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function extraer_todas_entradas():array{
        return $this->resultado->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function filasAfectadas():int{
        return $this->resultado->rowCount();
    }

    public function prepara($pre){
        return $this -> conexion -> prepare($pre);
    }

    
}