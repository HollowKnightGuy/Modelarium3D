<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Prueba inicio</title>
</head>

<body class="landingbody">
    <header>
        <a href="https://ppmodelarium3d.000webhostapp.com/" class="landing-link defaultbtn smodels room transition">Room</a>
        <div class="landing-user-opt">
            <?php
            use Lib\Utils;

            if (!Utils::isLogged()) : ?>
                <a href="<?= $_ENV['BASE_URL'] ?>login" class="landing-link defaultbtn login transition">Login</a>
                <a href="<?= $_ENV['BASE_URL'] ?>register" class="landing-link defaultbtn smodels transition">Register</a>
            <?php else : ?>
                <a href="<?= $_ENV['BASE_URL'] ?>models/" class="landing-link defaultbtn login transition">Models</a>

            <?php endif; ?>
        </div>
    </header>