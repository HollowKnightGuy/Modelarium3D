<?php

use Lib\Utils;
use Controllers\UsuarioController;
use Controllers\LikeController;
use Controllers\FavoritosController;
use Controllers\ModeloController;

$likeC = new LikeController();
$favC = new FavoritosController();
$modeloC = new ModeloController();
$usuarioC = new UsuarioController();

if(!isset($modelo)){
    $modelo = $_SESSION['lastmodelo'];
}else{
    $_SESSION['lastmodelo'] = $modelo;
}

$estilos = ['modelview', 'models'];
foreach ($estilos as $estilo) :  ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilo ?>.css">
<?php
endforeach;

if(!isset($message)){
    $message = ['comment' => ""];
}

$precio = number_format($modelo->precio, 2, ',', '');
$pparte1 = explode(',', $precio)[0];
$pparte2 = explode(',', $precio)[1];
if (isset($_SESSION['identity'])) {
    $likeEnModelo = $likeC->comprobarLike($_SESSION['identity']->id, $modelo->id);
    $favEnModelo = $favC->comprobarFavorito($_SESSION['identity']->id, $modelo->id);
}
require_once '../views/layout/header.php';
$error_img = '<img src=' . $_ENV['BASE_URL_PUBLIC'] . 'img/icons/error.svg alt=error>';
?>

<main class="modelview-main">

    <div class="model-view-container">
        <div class="model-view-card">

            <div class="model-view-model">
                <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/models/<?= $modelo->foto_modelo ?>" alt="<?= $modelo->foto_modelo ?>">
            </div>

        </div>

        <div class="model-view-info">

            <div class="model-info-1">
                <h1 id="model-view-title"><?= $modelo->titulo ?></h1>
                <h2 id="model-view-author">
                    Author:
                    <a href="<?= $_ENV['BASE_URL'] ?>model/author" class="linkpurple"> <?= UsuarioController::obtenerNombreUsuario($modelo->id_usuario)[0]['nombre'] ?></a>
                </h2>
                <div class="modelview-interactions ">
                        <?php if (isset($likeEnModelo) && $likeEnModelo != null) : ?>
                            <img onclick="location.href = '<?= $_ENV['BASE_URL'] ?>model/likeview/id=<?= $modelo->id ?>'" class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart-red.svg" alt="heart">
                        <?php else : ?>
                            <img onclick="location.href = '<?= $_ENV['BASE_URL'] ?>model/likeview/id=<?= $modelo->id ?>'" class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart.svg" alt="heart">
                        <?php endif; ?>
                        <span><?= $modelo->num_likes ?> Likes</span>
                        <?php if (isset($favEnModelo) && $favEnModelo != null) : ?>
                            <img onclick="location.href = '<?= $_ENV['BASE_URL'] ?>model/favview/id=<?= $modelo->id ?>'" class="favs-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/star-yellow.svg" alt="star">

                        <?php else : ?>
                            <img onclick="location.href = '<?= $_ENV['BASE_URL'] ?>model/favview/id=<?= $modelo->id ?>'" class="favs-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/star.svg" alt="star">
                        <?php endif; ?>

                        <span><?= $modelo->num_favs ?> Favorites</span>
                </div>
            </div>


            <div class="model-info-2">
                <div class="model-info-2-price">
                    <h1 id="modelview-price-title">Price</h1>
                    <div class="model--price textshadowlight">
                        <span class="price--bnumber"><?= $pparte1 ?>,</span><span class="price-snumber"><?= $pparte2 ?>€</span>
                    </div>
                </div>
                <div class="model-info-2-btn">
                    <!-- TODO: redireccionar al index y luego al ventascontroller -->
                    <?php $id_usuario = $usuarioC -> obtenerUsuario($_SESSION['identity']->email)?>
                    <form action="<?= $_ENV['BASE_URL'] ?>modelbuy/id=<?= $modelo->id?>"  method="POST"> <!-- FIXME:  (enviar id modelo e id usuario)-->
                        <button type="submit" name="action" value="buyNow" class="defaultbtn buynow-btn boxshadow">BUY NOW</button>
                    </form>
                </div>
            </div>


            <div class="model-info-3">

                <h3>Description</h3>
                <p><?= $modelo->descripcion ?> </p>

            </div>
        </div>

    </div>

    <div class="comment-container">

        <div class="cont-comment-1">
            <div class="comment-user-info">
                <img class="profileimg-comment" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/<?= isset($_SESSION['identity']) ? 'user/profilephoto/'.$_SESSION['identity'] -> foto_perfil : '/default/profile.jpg' ?>" alt="">
                <h1 class="username-modelview">You</h1>
                <span class="grey"></span><?= isset($_SESSION['identity']) ? explode("_", $_SESSION['identity'] -> rol)[1] : ''?></span>
            </div>

            <div class="comment-1">
                <form action="<?= $_ENV['BASE_URL'] ?>model/view/comment/id=<?= $modelo -> id ?>" method="POST">
                    <input type="text" name="comment" id="comment-1" placeholder="Comment...">
                    <button class="defaultbtn boxshadow" type="submit">Comment</button>
                </form>
            </div>
            <span class="red-error" style="position:relative; top: .8rem; color:#FB7676;">
                <?= $message['comment'] === "" ? "" : $error_img.$message['comment']; ?>
            </span>
        </div>

        <!-- <div class="cont-comment-2">
            <div class="comment-user-info">
                <img class="profileimg-comment" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/default/profile.jpg" alt="">
                <h1 class="username-modelview">User 1</h1>
            </div>

            <div class="comment-2-container">
                <div class="comment-2">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem voluptas reprehenderit, amet, at accusamus voluptate aliquam atque illo pariatur dolores facilis ratione accusantium sint totam voluptatum, error autem officiis ab. </p>
                </div>
                <img class="report-flag" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/red-flag.svg" alt="report flag">
            </div>

        </div> -->
    </div>
</main>

<?php
require_once '../views/layout/footer.php';
?>


