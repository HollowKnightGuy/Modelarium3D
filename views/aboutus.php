<?php 
$estilos = 'about'; ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilos ?>.css">
<?php
require_once '../views/layout/header.php';
?>


<main>
    <div class="about-us-container">
        <img id="loop1" class="loop" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/about-us/3d_loop_1.png" alt="deco">
        <img id="loop2" class="loop" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/about-us/3d_loop_2.png" alt="deco">

        <div class="about-us-card">
            <a href="https://github.com/Pablogrammer" target="blank" class="about-us-gitlink">
                <div class="about-us-card-1">
                    <img class="about-us-profile transition" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/about-us/profile1.png" alt="profileimg1">
                    <div class="about-us-text-1">
                        <h1 class="about-us-name">Pablo Cid Olmos</h1>
                        <p class="about-us-desc">21 Years old Full Stack developer graduated in Higher Education of Web Development. Ambitious person with big plans for the future. In love with web desing and 3D models</p>
                    </div>
                </div>
            </a>
            <a href="https://github.com/HollowKnightGuy" target="blank">
                <div class="about-us-card-2">
                    <div class="about-us-text-2">
                        <h1 class="about-us-name">Pablo Ortiz Gervilla</h1>
                        <p class="about-us-desc">19 years old Full Stack Web Developer graduated with a higher degree in web application development. Always eager to learn more about web design and lately about ThreeJS</p>
                    </div>
                    <img class="about-us-profile transition" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/about-us/profile2.png" alt="profileimg2">
                </div>
            </a>
        </div>
    </div>

</main>