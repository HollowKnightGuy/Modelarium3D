<?php 
$estilos = 'about'; ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilos ?>.css">
<?php
require_once '../views/layout/header.php';
$error_img = '<img class="error-img" width="200px" src='.$_ENV['BASE_URL_PUBLIC'].'img/icons/error.svg alt=error>';
?>

<div class="error">
    <span><?= $error_img ?></span>
    <h1>No se ha encontrado una pagina asociada a esta url</h1>
</div>
    
    <style>
        .error{
            width: 100%;
            height: 600px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #FB7676;
        }
        .error h1{
            font-size: var(--fs-300);
        }
    
        @media screen and (max-width:100px){
            .error-img{
                width: 100px;
            }
        }
    </style>