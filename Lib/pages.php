<?php


namespace Lib;
// ESTA CLASE TE BUSCA LA PÁGINA Y LO DEL ARRAY ES INNECESARIO SI USAS VARIABLES DE SESIONES
class Pages{
    public function render(string $pageName, array $params = null): void{
        if($params != null){
            foreach($params as $name => $value){
                $$name = $value;
            }
        }
        // require_once "views/layout/header.php";
        require_once "../views/$pageName.php";
        // require_once "views/layout/footer.php";
    }
}
?>