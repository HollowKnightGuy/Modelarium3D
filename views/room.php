<?php 
$estilos = 'about'; ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilos ?>.css">
<?php
require_once '../views/layout/header.php';
?>

<div id="cursor" class="none">
      <img src="./public/img/icons/visible-hover.svg" alt="eye.svg">
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <h1>IR A LA HABITACION</h1>
    <!-- <div class="loader">
      <div class="loadercolor">
        <img src="./public/img/logoloader/logoloadercolor.jpg" alt="logoloadergrey.jpg" class="logoloader">
        <h3 style="z-index: 5;">Cargando <span class="percentage" id="percentage"></h3>

        </div>
      </div> -->
    <!-- <div class="experience">
      <button style="display:none; position: absolute; background:transparent;">Volver al inicio</button>
      <canvas class="experience-canvas">

      </canvas>
    </div> -->
    <div id="rotator" style="height:100px;width:100px"></div>
