<?php

use Controllers\UsuarioController;
use Controllers\LikeController;
use Controllers\FavoritosController;

$likeC = new LikeController();
$favC = new FavoritosController();

$estilos = ['models'];
foreach ($estilos as $estilo) :  ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilo ?>.css">
<?php
endforeach;
require_once '../views/layout/header.php';
?>

<main>
    <div class="models-header">
        <h1>All Models</h1>
        <div class="models-header-select">
            <div class="select transition">

                <ul id="select" onclick="displaySelect()">
                    <li class="select-option transition default" onclick="changeModelsState(0, this)">All Models</li>
                    <li class="select-option transition" onclick="changeModelsState(1, this)">Level 1</li>
                    <li class="select-option transition" onclick="changeModelsState(2, this)">Level 2</li>
                    <li class="select-option transition" onclick="changeModelsState(3, this)">Level 3</li>
                </ul>
                <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/down-arrow.svg" alt="">
            </div>
            <!-- <form action="<?= $_ENV['BASE_URL'] ?>models" id="models-form" hidden> -->
            <select name="" id="form-select" onchange="console.log(2)" hidden>
                <option value="0" selected>All Levels</option>
                <option value="1">D1</option>
                <option value="2">D2</option>
                <option value="3">D3</option>
            </select>
            <!-- </form> -->

        </div>
    </div>
    <span class="red-error">
        <?= isset($_SESSION['error_like']) && $_SESSION['error_like'] === "" ? "" : $_SESSION['error_like'] ?>
        <br>
        <br>
        <?= isset($_SESSION['error_fav']) && $_SESSION['error_fav'] === "" ? "" : $_SESSION['error_fav'] ?>
    </span>


    <div class="models">
        <?php if (isset($modelos)) : ?>
            <?php foreach ($modelos as $modelo) :
                $precio = number_format($modelo->getPrecio(), 2, ',', '');
                $pparte1 = explode(',', $precio)[0];
                $pparte2 = explode(',', $precio)[1];
                if(isset($_SESSION['identity'])){
                    $likeEnModelo = $likeC->comprobarLike($_SESSION['identity']->id, $modelo->getId());
                    $favEnModelo = $favC->comprobarFavorito($_SESSION['identity']->id, $modelo->getId());
                }
            ?>

                <div class="model">
                    <div class="model--model">
                        <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/models/<?= $modelo->getFoto_Modelo() ?>" alt="model">
                    </div>
                    <div class="model--modelinfo">
                        <div class="infomodel">
                            <div class="model--title"><?= $modelo->getTitulo() ?></div>
                            <div class="model--author ">Author: <a href="<?= $_ENV['BASE_URL'] ?>model/author" class="linkpurple"><?= UsuarioController::obtenerNombreUsuario($modelo->getId_usuario())[0]['nombre'] ?></a></div>
                        </div>
                        <div class="model--likesfavs textshadowlight">
                            <div class="model--likes" onclick="location.href = '<?= $_ENV['BASE_URL'] ?>model/like/id=<?= $modelo->getId() ?>'">
                                <?php if (isset($likeEnModelo) && $likeEnModelo != null) : ?>
                                    <img class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart-red.svg" alt="heart">
                                <?php else : ?>
                                    <img class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart.svg" alt="heart">
                                <?php endif; ?>
                                <span><?= $modelo->getNum_likes() ?></span>
                            </div>
                            <div class="model--favs" onclick="location.href = '<?= $_ENV['BASE_URL'] ?>model/fav/id=<?= $modelo->getId() ?>'">
                                <?php if (isset($favEnModelo) && $favEnModelo != null) : ?>
                                    <img class="favs-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/star-yellow.svg" alt="star">

                                <?php else : ?>
                                    <img class="favs-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/star.svg" alt="star">
                                <?php endif; ?>

                                <span><?= $modelo->getNum_favs() ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="buy">
                        <div class="model--seebtn">
                            <button class="boxshadow defaultbtn transition" onclick="location.href = '<?= $_ENV['BASE_URL'] ?>models/view/id=<?= $modelo->getId() ?>'">SEE MORE</button>
                        </div>
                        <div class="model--price textshadowlight">
                            <span class="price--bnumber"><?= $pparte1 ?>,</span><span class="price-snumber"><?= $pparte2 ?>€</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>
<script>
    let displayed = false;
    const ulSelect = document.getElementById("select");
    const ulOptions = document.getElementsByClassName("select-option");
    const formSel = document.getElementById("form-select");
    const modelsForm = document.getElementById("models-form");
    const options = []
    formSel.childNodes.forEach(element => {
        if (element.nodeType === Node.ELEMENT_NODE) options.push(element)
    });

    function changeModelsState(option, element) {
        for (let i = 0; i < 3; i++) {
            ulOptions[i].classList.remove("default");
        }

        element.classList.toggle("default");
        formSel.value = option;
        modelsForm.submit()
    }


    function displaySelect() {
        if (displayed) {
            for (let i = 0; i < 4; i++) {
                if (ulOptions[i].classList.contains('default')) {
                    ulOptions[i].style.display = "block";

                } else {
                    ulOptions[i].style.display = "none";
                }
            }
            displayed = false;
        } else {
            for (let i = 0; i < 4; i++) {
                ulOptions[i].style.display = "block";
                displayed = true;
            }
        }
    }
</script>

<?php
require_once '../views/layout/footer.php';
?>