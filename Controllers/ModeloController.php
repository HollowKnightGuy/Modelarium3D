<?php

namespace Controllers;
use Controllers\ComentariosController;
use Models\Modelo;
use Lib\Pages;
use Lib\Utils;
use Controllers\VentasController;
class ModeloController
{


    private Pages $pages;
    private ComentariosController $comentarioC;
    private Modelo $modelo;
    public function __construct()
    {
        $this->pages = new Pages();
        $this->comentarioC = new ComentariosController();
        $this->modelo = new Modelo("", "", "", "", "", "", "", "", "", "", "", "", "", "");
    }

    public function buscar():void{
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $texto = $_POST['search'];
            $modelos = $this -> modelo -> ObtenerModelosBuscar($texto);
            $this->pages->render('modelos/models', ['modelos' => $modelos]);
        }
    }


    public function showAll()
    {
        $modelos = $this->modelo->obtenerModelos();
        $this->pages->render("modelos/models", ['modelos' => $modelos]);
    }

    public function obtenerModelosPendientes()
    {
        return $this->modelo->obtenerModelosPendientes();
    }

    public function crear($datos = NULL)
    {
        $message = ['titulo' => "", 'precio' => "", 'descripcion_modelo' => "", 'modelo_glb' => "", 'modelo_foto' => ""];

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            return $this->modelo->guardar($datos);
        } else {
            $this->pages->render("modelos/create_edit_model", ['message' => $message]);
        }
    }

    public function editar($id_modelo)
    {
        if(Utils::isCreator() || Utils::isAdmin()){
            $modelo = $this -> obtenerModeloPorId($id_modelo);

            $message = ['titulo' => "", 'precio' => "", 'descripcion_modelo' => "", 'modelo_glb' => "", 'modelo_foto' => ""];
            $datos_guardados = ['titulo' => $modelo->titulo, 'precio' => $modelo->precio, 'descripcion_modelo' => $modelo->descripcion, 'modelo_glb' => $modelo->archivo_modelo, 'modelo_foto' => $modelo->foto_modelo];
            $this->pages->render("modelos/create_edit_model", ['message' => $message, 'datos_guardados' => $datos_guardados]);
        }else{
            Utils::irModels();
        }
    }

    public function cambiarEstado($id)
    {
        return $this->modelo->cambiarEstado($id);
    }

    public function borrar($id)
    {
        if(Utils::isCreator() || Utils::isAdmin()){
            if(Utils::isAdmin()){
                return $this->modelo->borrar($id);
            }else{
                $modelo = $this -> obtenerModeloPorId($id);
                if($modelo -> id_usuario === Utils::idLoggedUsuario() ){
                    return $this->modelo->borrar($id);
                }else{
                    Utils::irProfile();
                }
            }
        }
    }

    public function mostrarModelo($id_modelo)
    {
        $modelo = $this -> obtenerModeloPorId($id_modelo);
        if(!is_object($modelo)) Utils::irModels();
        $comentarios = $this -> comentarioC -> obtenerComentarios($id_modelo);    
        $this->pages->render("modelos/modelview", ['modelo' => $modelo, 'comentarios' => $comentarios]);
    }

    public function obtenerModelo($id_usuario, $titulo)
    {
        return $this->modelo->obtenerModelo($id_usuario, $titulo);
    }

    public function obtenerModeloPorId($idmodelo)
    {
        return $this->modelo->obtenerModeloPorId($idmodelo);
    }

    public function obtenerModelosUsuario($idusuario)
    {
        return $this->modelo->obtenerModelosUsuario($idusuario);
    }

    public function obtenerModelosUsuarioNP($idusuario)
    {
        return $this->modelo->obtenerModelosUsuarioNP($idusuario);
    }
    

    public function like($idmodelo)
    {
        if (Utils::isLogged()) {
            return $this->modelo->like($idmodelo);
        } else {
            Utils::irLogin();
        }
    }

    public function revertirLike($idmodelo)
    {
        if (Utils::isLogged()) {
            return $this->modelo->revertirLike($idmodelo);
        } else {
            Utils::irLogin();
        }
    }

    public function favorito($idmodelo)
    {
        if (Utils::isLogged()) {
            return $this->modelo->favorito($idmodelo);
        } else {
            Utils::irLogin();
        }
    }

    public function revertirFavorito($idmodelo)
    {
        if (Utils::isLogged()) {
            return $this->modelo->revertirFavorito($idmodelo);
        } else {
            Utils::irLogin();
        }
    }

    public function cambiarPrivado($id_modelo){
        $this -> modelo -> cambiarPrivado($id_modelo);
        header("Location: ".$_ENV['BASE_URL']."profile");
    }

    public function isPrivado($id_modelo){
        return $this -> modelo -> isPrivado($id_modelo);
    }

    public function obtenerModelosPrivadosUsuario($id_usuario){
        return $this -> modelo -> obtenerModelosPrivadosUsuario($id_usuario);
    }
    public function descargar($id){
        $modelo = $this -> obtenerModeloPorId($id); 
        if($modelo !== false){
            $nombre_archivo = $modelo -> archivo_modelo;
            $comprado = VentasController::comprobarVentaDescarga($id);
            if($comprado){
                $fileName = $nombre_archivo;
                $filePath = $_ENV['BASE_URL_PUBLIC']."3dmodels/".$fileName;
                var_dump(file_exists($filePath));
                var_dump(($filePath));
                    // Define headers
                    header("Cache-Control: public");
                    header("Content-Description: File Transfer");
                    header("Content-Disposition: attachment; filename=$fileName");
                    header("Content-Type: type/glb");
                    header("Content-Transfer-Encoding: binary");
                    
                    // Read the file
                    readfile($filePath);
                }
            else{
                Utils::irView($id);
            }
        }else{
            Utils::irView($id);
        }
    }
}
