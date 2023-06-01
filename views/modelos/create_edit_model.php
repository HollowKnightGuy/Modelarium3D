<?php 
$estilos = [ 'form','models'];
foreach ($estilos as $estilo) :  ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>css/<?= $estilo ?>.css">
<?php
endforeach;
require_once '../views/layout/header.php';
?>

    <main>
        <div class="container">
            <h1 class="title">Upload your Model</h1>
            <form action="#" method="GET" class="form">
                <div class="model-form">
                    <div class="input-container selectfilecontainer">
                        <button class="select-file-btn transition">
                            <span>Select File</span>
                            <img src="../img/icons/upload-file2.svg" alt="upload-file">
                        </button>
                        <div>
                            <span class="required">*</span>
                            <input class="selectfileinput" type="text" placeholder="Model.glb" readonly>
                            <input type="file" name="file" id="file" hidden> 
                        </div>
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
                </div>
                <input class="submit transition" type="submit" value="UPLOAD MODEL">
                <span class="textinfo">The model being uploaded will be checked by the administrators and if it deserve to be in Modelarium it will be up.</span>
            </form>
        </div>
    </main>
   