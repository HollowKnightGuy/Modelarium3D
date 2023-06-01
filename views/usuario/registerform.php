<?php 
$estilos = 'form'; ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>css/<?= $estilos ?>.css">
<?php
require_once '../views/layout/header.php';
$error_img = '<img src='.$_ENV
['BASE_URL'].'img/icons/error.svg alt=error>';
?>

<div class="container registerContainer">
    <h1 class="title">Register</h1>
    <form action="<?= $_ENV['BASE_URL']?>register" method="POST" class="form"  enctype="multipart/form-data">
        <div class="input-container">
            <input type="text" name="data[username]" id="username" required placeholder="Username" value="<?= $datos_guardados['username'] ?? "" ?>"> <span class="required">*</span>
        </div>
        <span class="red-error">
            <?= $message['nombre'] === "" ? "" : $error_img.$message['nombre']; ?>
        </span>

        <div class="input-container">
            <input type="email" name="data[email]" id="email" required placeholder="email@example.com" value="<?= $datos_guardados['email'] ?? "" ?>"> <span class="required">*</span>
        </div>
        <span class="red-error">
            <?= $message['email'] === "" ? "" : $error_img.$message['email']; ?>
        </span>

        <div class="input-container">
            <input type="password" name="data[pass]" id="pass" required  placeholder="··············" value="<?= $datos_guardados['password'] ?? "" ?>"> <span class="required">*</span>
        </div>
        <span class="red-error">
            <?= $message['password'] === "" ? "" : $error_img.$message['password']; ?>
        </span>

        <div class="input-container">
            <button class="select-file-btn transition" onclick="getFile()"><span>Select File</span><img src="<?= $_ENV['BASE_URL'] ?>img/icons/upload-file2.svg" alt="upload-file"></button>
            <input type="text" id="inputImgName" placeholder="ProfilePhoto.png" readonly>
            <input type="file" required name="file" id="file" required hidden> <span class="required">*</span>
        </div>
        <span class="red-error">
            <?= $message['imagen'] === "" ? "" : $error_img.$message['imagen']; ?>
        </span>

        <div class="input-container">
            <textarea name="data[desc]" id="desc" rows="10"     placeholder="Profile Description"><?= $datos_guardados['desc'] ?? "" ?></textarea>
        </div>
        <span class="red-error">
            <?= $message['descripcion'] === "" ? "" : $error_img.$message['descripcion']; ?>
        </span>

        <span class="red-error">
            <?= $message['generico'] === "" ? "" : $error_img.$message['generico']; ?>
        </span>
        <input type="submit" class="submit transition" value="REGISTER">
        <span>Already have an account? <a class="linkpurple" href="<?= $_ENV['BASE_URL'] ?>login">Log in</a></span>
    </form>
</div>
<script>
    // FORM INPUTS VARIABLES
    const selectFileInput = document.getElementById("file");
    const inputImgName = document.getElementById("inputImgName");
    
    function getFile(){
        selectFileInput.click();
        console.log(selectFileInput);
    }

    selectFileInput.onchange = function(){
        arrayImg = selectFileInput.value.split("\\");
        lengthArr = arrayImg.length;
        inputImgName.value = arrayImg[lengthArr - 1]
    }


</script>