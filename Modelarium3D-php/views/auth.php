<?php

    use Lib\Security;
    echo json_encode(Security::clavesecreta());
    $passw = Security::encriptaPassw('mipass1234');


    if(Security::validaPassw('probando',$passw)){
        echo json_encode('Password Correcto');
    }else{
        echo json_encode('Password Incorrecto');

    }

    echo json_encode(Security::crearToken(Security::clavesecreta(), ['mipass1234']))

?>