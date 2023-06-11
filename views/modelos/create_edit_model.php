<?php
$estilos = ['form', 'models'];
foreach ($estilos as $estilo) :  ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilo ?>.css">
<?php
endforeach;
require_once '../views/layout/header.php';
$error_img = '<img src=' . $_ENV['BASE_URL_PUBLIC'] . 'img/icons/error.svg alt=error>';

?>

<main>
    <div class="container">
        <?php if(isset($datos_guardados)):?>
            <h1 class="title">Edit your Model</h1>
        <?php else:?>
            <h1 class="title">Upload your Model</h1>
        <?php endif;?>

        <form action="<?php $_ENV['BASE_URL'] ?>../creator/request" method="POST" class="form" enctype="multipart/form-data">
            <div class="model-form">

            <div class="double-input-section">
                    <div class="input-container">
                        <input type="text" value="<?= $datos_guardados['titulo'] ?? "" ?>" name="data[title]" placeholder="Title">
                        <span class="required requiredtitle">*</span>
                    </div>
                    <div class="input-container">
                        <input type="text" id="price" value="<?= $datos_guardados['precio'] ?? "" ?>" name="data[price]" placeholder="Price (XX.XX EUR)">
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
                <span class="red-error">
                    <?= $message['modelo_glb'] === "" ? "Format allowed: .glb" : $error_img . $message['modelo_glb']; ?>
                </span>
                <div class="input-container selectfilecontainer">
                    <input style="color:white; background-color:var(--primary-color)" type="button" value="Select Photo" class="select-file-btn transition" onclick="getFile2()">
                    </input>
                    <div>
                        <span class="required">*</span>
                        <input class="selectfileinput2" id="inputImgName2" type="text" placeholder="Model-photo.jpg" readonly>
                        <input type="file" name="model_photo" id="file2" hidden>
                    </div>
                </div>
                <span class="red-error">
                    <?= $message['modelo_foto'] === "" ? "Aspect Ratio recommended: 6/11. Format allowed: .png .jpg .jpeg" : $error_img . $message['modelo_foto']; ?>
                </span>
            </div>
            <input class="submit transition" type="submit" value="UPLOAD MODEL">
            <span class="textinfo">The model being uploaded will be checked by the administrators and if it deserve to be in Modelarium it will be up.</span>
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