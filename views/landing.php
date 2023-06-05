<?php
require_once '../views/layout/landingheader.php';
 ?>
<link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC']?>css/landing.css">   

    <div class="landing">
        <div class="landing-title">
            <h1>Modelarium 3D</h1>
        </div>
        <p class="landing-text">Welcome to Modelarium 3D, your one-stop shop for incredible high-quality 3D models. Explore our meticulously curated collection and find the perfect models to enhance your projects. Join our thriving creative community and unleash your imagination in the world of 3D art. Start creating with Modelarium 3D today!</p>
        <div class="buttons">
            <a href="<?= $_ENV['BASE_URL']?>/models" class="landing-link defaultbtn smodels transition">See models</a>

        </div>
    </div>
</body>
</html>