<?php 

    namespace Models;
    use Lib\Utils;
    use Lib\BaseDatos;
    use PDO;
    use PDOException;

    class Favoritos{

        private BaseDatos $conexion;
        private string $id;
        private string $idusuario;
        private string $idmodelo;

        public function __construct($id, $idusuario, $idmodelo){
            $this -> id = $id;
            $this -> idusuario = $idusuario;
            $this -> idmodelo = $idmodelo;
            $this -> conexion = new BaseDatos();
            
        }

        public function insertFavorito($id_usuario, $id_modelo):bool{
            $consulta = $this->conexion->prepara('INSERT INTO favoritos(id_usuario, id_modelo) VALUES(:id_usuario, :id_modelo)');
            $consulta->bindParam(':id_usuario', $id_usuario);
            $consulta->bindParam(':id_modelo', $id_modelo);
    
            try {
                $consulta->execute();
                return true;
            } catch (PDOException $err) {
                echo "Error en la consulta: " . $err->getMessage();
                return false;
            }
        }

        public function deleteFavorito($id_usuario, $id_modelo):bool{
            $consulta = $this->conexion->prepara('DELETE FROM favoritos WHERE id_usuario=:id_usuario AND id_modelo=:id_modelo');
            $consulta->bindParam(':id_usuario', $id_usuario);
            $consulta->bindParam(':id_modelo', $id_modelo);
    
            try {
                $consulta->execute();
                return true;
            } catch (PDOException $err) {
                echo "Error en la consulta: " . $err->getMessage();
                return false;
            }
        }

        public function comprobarfavorito($idusuario, $idmodelo){
            $result = false;
            $cons = $this->conexion->prepara("SELECT * FROM favoritos WHERE id_usuario = :idusuario AND id_modelo = :idmodelo");
            $cons->bindParam(":idusuario", $idusuario);
            $cons->bindParam(":idmodelo", $idmodelo);
            try {
                $cons->execute();
                if ($cons && $cons->rowCount() == 1) {
                    return $cons->fetch(PDO::FETCH_OBJ);
                }
            } catch (PDOException $err) {
                return false;
            }
        }

        public function obtenerModelosFav($id_usuario){

            $cons = $this->conexion->prepara("SELECT * FROM favoritos WHERE id_usuario = :id_usuario");
            $cons->bindParam(":id_usuario", $id_usuario);
            try {
                $cons->execute();
                if ($cons && $cons->rowCount() >= 1) {
                    return $cons->fetchAll(PDO::FETCH_OBJ);
                }
            } catch (PDOException $err) {
                echo "Error en la consulta".$err;
                return false;
            }
        }

        /**
         * Get the value of idmodelo
         */ 
        public function getIdmodelo()
        {
                return $this->idmodelo;
        }

        /**
         * Set the value of idmodelo
         *
         * @return  self
         */ 
        public function setIdmodelo($idmodelo)
        {
                $this->idmodelo = $idmodelo;

                return $this;
        }

        /**
         * Get the value of idusuario
         */ 
        public function getIdusuario()
        {
                return $this->idusuario;
        }

        /**
         * Set the value of idusuario
         *
         * @return  self
         */ 
        public function setIdusuario($idusuario)
        {
                $this->idusuario = $idusuario;

                return $this;
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
    }
?>