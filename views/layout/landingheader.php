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
        <a href="<?= $_ENV['BASE_URL']?>" class="landing-link defaultbtn smodels room transition">Room</a>
        <div class="landing-user-opt">
            <a href="<?= $_ENV['BASE_URL']?>login" class="landing-link defaultbtn login transition">Login</a>
            <a href="<?= $_ENV['BASE_URL']?>register" class="landing-link defaultbtn smodels transition">Register</a>
        </div>
    </header>