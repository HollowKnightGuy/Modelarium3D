<?php

use Lib\Utils;

$estilos = 'form'; ?>
<link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilos ?>.css">
<?php
require_once '../views/layout/header.php';
$error_img = '<img src=' . $_ENV['BASE_URL_PUBLIC'] . 'img/icons/error.svg alt=error>';
?>
<title>Modelarium3D - Register</title>

<div class="container registerContainer">

    <h1 class="title"><?= Utils::isAdmin() ? "Create User" : "Register" ?></h1>
    <form action="<?= $_ENV['BASE_URL'] ?><?= Utils::isAdmin() ? "admin/createuser" : "register" ?>" method="POST" class="form" enctype="multipart/form-data">
        <div class="input-container">
            <input type="text" name="data[username]" id="username" required placeholder="Username" value="<?= $datos_guardados['username'] ?? "" ?>"> <span class="required">*</span>
        </div>
        <span class="red-error">
            <?= $message['nombre'] === "" ? "" : $error_img . $message['nombre']; ?>
        </span>

        <div class="input-container">
            <input type="email" name="data[email]" id="email" required placeholder="email@example.com" value="<?= $datos_guardados['email'] ?? "" ?>"> <span class="required">*</span>
        </div>
        <span class="red-error">
            <?= $message['email'] === "" ? "" : $error_img . $message['email']; ?>
        </span>

        <div class="input-container">
            <input type="password" name="data[pass]" id="pass" required placeholder="··············" value="<?= $datos_guardados['password'] ?? "" ?>"> <span class="required">*</span>
        </div>
        <span class="red-error">
            <?= $message['password'] === "" ? "" : $error_img . $message['password']; ?>
        </span>

        <div class="input-container selectfilecontainer">
            <input style="color:white; background-color:var(--primary-color)" type="button" value="Select File" class="select-file-btn transition" onclick="getFile()">
            </input>
            <div>
                <span class="required">*</span>
                <input class="selectfileinput" id="inputImgName" type="text" placeholder="profilephoto.jpg" readonly>
                <input type="file" name="file" id="file" hidden required>
            </div>
        </div>
        <?php if ($message['imagen'] === "") : ?>
            <span>Format allowed: .png .jpg .jpeg. <br> Max size: 150Kb</span>
        <?php else : ?>
            <span class="red-error">
                <?= $error_img . $message['imagen'] ?>
            </span>
        <?php endif; ?>

        <div class="input-container">
            <textarea name="data[desc]" id="desc" rows="10" placeholder="Profile Description"><?= $datos_guardados['desc'] ?? "" ?></textarea>
        </div>
        <span class="red-error">
            <?= $message['descripcion'] === "" ? "" : $error_img . $message['descripcion']; ?>
        </span>

        <span class="red-error">
            <?= $message['generico'] === "" ? "" : $error_img . $message['generico']; ?>
        </span>
        <?php if (Utils::isAdmin()) : ?>

            <input type="submit" class="submit transition" value="CREATE USER">
        <?php else : ?>
            <input type="submit" class="submit transition" value="REGISTER">
            <span>Already have an account? <a class="linkpurple" href="<?= $_ENV['BASE_URL'] ?>login">Log in</a></span>
        <?php endif; ?>
    </form>
</div>
<script>
    // FORM INPUTS VARIABLES
    const selectFileInput = document.getElementById("file");
    const inputImgName = document.getElementById("inputImgName");

    function getFile() {
        selectFileInput.click();
    }

    selectFileInput.onchange = function() {
        arrayImg = selectFileInput.value.split("\\");
        lengthArr = arrayImg.length;
        inputImgName.value = arrayImg[lengthArr - 1]
    }
</script>

<?php
require_once '../views/layout/footer.php';
?>