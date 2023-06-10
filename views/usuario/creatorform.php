<?php
$estilos = 'form'; ?>
<link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilos ?>.css">
<?php
require_once '../views/layout/header.php';
$error_img = '<img src=' . $_ENV['BASE_URL_PUBLIC'] . 'img/icons/error.svg alt=error>';
?>

<main>
    <div class="container">
        <h1 class="title">Creator Form</h1>
        <form action="<?php $_ENV['BASE_URL'] ?>./becreator" method="POST" class="form" enctype="multipart/form-data">

            <div class="creator-form-section">
                <div class="input-container">
                    <input type="email" name="data[email]" value="<?= $datos_guardados['email'] ?? "" ?>" id="email" placeholder="Paypal Email Adress">
                    <span class="required">*</span>
                </div>
                <?php if ($message['email'] === "") :  ?>
                    <span class="textinfo">In case you sell any of the models is uploaded the money wil be sent to this Paypal address</span>
                <?php else : ?>
                    <span class="red-error">
                        <?= $message['email'] === "" ? "" : $error_img . $message['email']; ?>
                    </span>
                <?php endif; ?>

            </div>
            <div class="creator-form-section">
                <div class="input-container">
                    <textarea name="data[desc]" id="desc" rows="10" placeholder="Profile Description"><?= $datos_guardados['desc'] ?? "" ?></textarea><span class="required">*</span>

                </div>
                <?php if ($message['desc'] === "") :  ?>
                    <span class="textinfo">A profile description is mandatory to have for every creator in Modelarium</span>
                <?php else : ?>
                    <span class="red-error">
                        <?= $error_img . $message['desc']; ?>
                    </span>
                <?php endif; ?>
            </div>

            <div class="model-form">
                <div class="creator-form-section">
                    <h2>Upload your first model</h2>
                    <span class="textinfo">The model being uploaded will be checked by the administrators and if it deserve to be in Modelarium and if you can be a creator</span>
                </div>

                <div class="double-input-section">
                    <div class="input-container">
                        <input type="text" value="<?= $datos_guardados['title'] ?? "" ?>" name="data[title]" placeholder="Title">
                        <span class="required requiredtitle">*</span>
                    </div>
                    <div class="input-container">
                        <input type="text" id="price" value="<?= $datos_guardados['price'] ?? "" ?>" name="data[price]" placeholder="Price (XX.XX EUR)">
                        <span class="required">*</span>
                    </div>
                </div>
                <span class="red-error">
                    <?= $message['titulo'] === "" ? "" : $error_img . $message['titulo']; ?>
                </span>
                <span class="red-error">
                    <?= $message['precio'] === "" ? "" : $error_img . $message['precio']; ?>
                </span>
                <div class="input-container">
                    <textarea name="data[descripcion_modelo]" id="descripcion_modelo" rows="10" placeholder="Model Description"><?= $datos_guardados['descripcion_modelo'] ?? "" ?></textarea>
                    <span class="required">*</span>
                </div>
                <span class="red-error">
                    <?= $message['descripcion_modelo'] === "" ? "" : $error_img . $message['descripcion_modelo']; ?>
                </span>
                <div class="input-container selectfilecontainer">
                    <input style="color:white; background-color:var(--primary-color)" type="button" value="Select File" class="select-file-btn transition" onclick="getFile()">
                    </input>
                    <div>
                        <span class="required">*</span>
                        <input class="selectfileinput" id="inputImgName" type="text" placeholder="Model.glb" readonly>
                        <input type="file" name="model_file" id="file" hidden>
                    </div>
                </div>
                <?php if ($message['modelo_glb'] === "") : ?>
                    <span>Format allowed: .glb <br> Max size: 300Kb</span>
                <?php else : ?>
                    <span class="red-error">
                        <?= $error_img . $message['modelo_glb']; ?>
                    </span>
                <?php endif; ?>
                <div class="input-container selectfilecontainer">
                    <input style="color:white; background-color:var(--primary-color)" type="button" value="Select Photo" class="select-file-btn transition" onclick="getFile2()">
                    </input>
                    <div>
                        <span class="required">*</span>
                        <input class="selectfileinput2" id="inputImgName2" type="text" placeholder="Model-photo.jpg" readonly>
                        <input type="file" name="model_photo" id="file2" hidden>
                    </div>
                </div>
                <?php if ($message['modelo_foto'] === "") : ?>
                <span>Aspect Ratio recommended: 6/11. <br> Format allowed: .png .jpg .jpeg <br> Max size: 150Kb</span>
                <?php else: ?>
                <span class="red-error">
                    <?= $message['modelo_foto'] === "" ? "Aspect Ratio recommended: 6/11. Format allowed: .png .jpg .jpeg" : $error_img . $message['modelo_foto']; ?>
                </span>
                <?php endif;?>
            </div>

            <input class="submit transition" type="submit" value="BE A CREATOR">
            <span class="textinfo">To be a creator may take a few days so that the administrator must decide. You will receive an E-mail with the veredict.</span>
        </form>
    </div>
</main>
<script>
    // FORM INPUTS VARIABLES
    const selectFileInput = document.getElementById("file");
    const selectFileInput2 = document.getElementById("file2");
    const inputImgName = document.getElementById("inputImgName");
    const inputImgName2 = document.getElementById("inputImgName2");

    function getFile() {
        selectFileInput.click();
    }

    selectFileInput.onchange = function() {
        arrayImg = selectFileInput.value.split("\\");
        lengthArr = arrayImg.length;
        inputImgName.value = arrayImg[lengthArr - 1]
    }

    function getFile2() {
        selectFileInput2.click();
    }

    selectFileInput2.onchange = function() {
        arrayImg = selectFileInput2.value.split("\\");
        lengthArr = arrayImg.length;
        inputImgName2.value = arrayImg[lengthArr - 1]
    }
</script>
<?php
require_once '../views/layout/footer.php';
?>