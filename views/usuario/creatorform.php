<?php 
$estilos = 'form'; ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilos ?>.css">
<?php
require_once '../views/layout/header.php';
?>

    <main>
        <div class="container">
            <h1 class="title">Creator Form</h1>
            <form action="<?php $_ENV['BASE_URL']?>/creator/request" method="POST" class="form" enctype="multipart/form-data">
                
                <div class="creator-form-section">
                    <div class="input-container">
                        <input type="email" name="email" id="email" placeholder="Paypal Email Adress"> <span class="required">*</span>
                    </div>
                    <span class="textinfo">In case you sell any of the models is uploaded the money wil be sent to this Paypal address</span>
                </div>
    
                <div class="creator-form-section">
                    <div class="input-container">
                        <textarea name="desc" id="desc" rows="10" placeholder="Profile Description"></textarea><span class="required">*</span>

                    </div>
                    <span class="textinfo">A profile description is mandatory to have for every creator in Modelarium</span>
                </div>
    
                
                <div class="model-form">
                    <div class="creator-form-section">
                        <h2>Upload your first model</h2>
                        <span class="textinfo">The model being uploaded will be checked by the administrators and if it deserve to be in Modelarium and if you can be a creator</span>
                    </div>
    
                    <div class="double-input-section">
                        <div class="input-container">
                            <input type="text" placeholder="Title">
                            <span class="required requiredtitle">*</span>
                        </div>
                        <div class="input-container">
                            <input type="number" placeholder="Price">
                            <span class="required">*</span>
                        </div>
                    </div>
                    
                    <div class="input-container">
                        <textarea name="desc" id="desc" rows="10" placeholder="Model Description"></textarea>
                    </div>
                    <div class="input-container selectfilecontainer">
                        <button class="select-file-btn transition" onclick="getFile()">
                            <span>Select File</span>
                            <img src="<?= $_ENV['BASE_URL_PUBLIC']?>img/icons/upload-file2.svg" alt="file.svg">
                        </button>
                        <div>
                            <span class="required">*</span>
                            <input class="selectfileinput" id="inputImgName" type="text" placeholder="Model.glb" readonly>
                            <input type="file" name="data[file]" id="file" hidden required> 
                        </div>
                    </div>
                
                    <div class="input-container selectfilecontainer">
                        <button class="select-file-btn transition" onclick="getFile2()">
                            <span>Select Photo</span>
                            <img src="<?= $_ENV['BASE_URL_PUBLIC']?>img/icons/camera.svg" alt="camera.svg">
                        </button>
                        <div>
                            <span class="required">*</span>
                            <input class="selectfileinput2" id="inputImgName2" type="text" placeholder="Model-photo.jpg" readonly>
                            <input type="file" name="data[file_photo]" id="file2" hidden required> 
                        </div>
                    </div>
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