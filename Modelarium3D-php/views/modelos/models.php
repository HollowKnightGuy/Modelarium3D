<?php

use Controllers\UsuarioController;
use Controllers\LikeController;
use Controllers\FavoritosController;
use Lib\Utils;

$likeC = new LikeController();
$favC = new FavoritosController();
$usuarioC = new UsuarioController();


$estilos = ['models'];
foreach ($estilos as $estilo) :  ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilo ?>.css">
<?php
endforeach;
require_once '../views/layout/header.php';
$tick_img = '<img src=' . $_ENV['BASE_URL_PUBLIC'] . 'img/icons/tick-normal.svg alt=succesfull.svg>';

?>
<title>Modelarium3D - Models</title>

<main>
    <?php if (isset($modelos) && !empty($modelos)) : ?>
        <?php if (isset($_SESSION['registro_exito']) && $_SESSION['registro_exito']) :
                $_SESSION['registro_exito'] = false; ?>
                <span class="red-error" style="color:#33a115;display:flex;align-items:center;gap:.7rem;font-size:var(--fs-200);"><?= $tick_img . "Model request sended succesfully" ?></span>
            <?php endif ?>
        <div class="models-header">
            <h1>All Models</h1>
        </div>

        <div class="models">
            <?php foreach ($modelos as $modelo) :
                $precio = number_format($modelo->getPrecio(), 2, ',', '');
                $pparte1 = explode(',', $precio)[0];
                $pparte2 = explode(',', $precio)[1];
                if (Utils::isLogged()) {
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
                            <div class="model--author ">Author: <a href="<?= $_ENV['BASE_URL'] ?>profile/author/id=<?= $modelo->getId_usuario() ?>" class="linkpurple"><?= $usuarioC->obtenerUsuarioPorId($modelo->getId_usuario())->nombre ?></a></div>
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
        </div>
    <?php else : ?>
        <div class="models-header">
            <h1>No models found</h1>
        </div>
    <?php endif; ?>
</main>
<script>
    let displayed = false;
    const ulSelect = document.getElementById("select");
    const ulOptions = document.getElementsByClassName("select-option");
    const modelsForm = document.getElementById("models-form");
    const options = []


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