<?php

use Lib\Utils;
use Controllers\UsuarioController;
use Controllers\LikeController;
use Controllers\FavoritosController;
use Controllers\ModeloController;
use Controllers\VentasController;


$likeC = new LikeController();
$favC = new FavoritosController();
$modeloC = new ModeloController();
$usuarioC = new UsuarioController();
$ventasC = new VentasController();


if (!isset($modelo)) {
    $modelo = $_SESSION['lastmodelo'];
} else {
    $_SESSION['lastmodelo'] = $modelo;
}

$estilos = ['modelview', 'models'];
foreach ($estilos as $estilo) :  ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilo ?>.css">
<?php
endforeach;

if (!isset($message)) {
    $message = ['comment' => ""];
}

$precio = number_format($modelo->precio, 2, ',', '');
$pparte1 = explode(',', $precio)[0];
$pparte2 = explode(',', $precio)[1];
if (Utils::isLogged()) {
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
                    <a href="../../profile/author/id=<?= $modelo->id_usuario ?>" class="linkpurple"><?= $usuarioC->obtenerUsuarioPorId($modelo->id_usuario)->nombre ?></a>
                </h2>
                <div class="modelview-interactions ">
                    <?php if (isset($likeEnModelo) && $likeEnModelo != null) : ?>
                        <img onclick="location.href = '<?= $_ENV['BASE_URL'] ?>model/likeview/id=<?= $modelo->id ?>'" class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart-red.svg" alt="heart">
                        <img  class="likes-img" hidden src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart.svg">

                    <?php else : ?>
                        <img class="likes-img" hidden src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart-red.svg">
                        <img onclick="location.href = '<?= $_ENV['BASE_URL'] ?>model/likeview/id=<?= $modelo->id ?>'" class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart.svg" alt="heart">
                    <?php endif; ?>
                    <span><?= $modelo->num_likes ?> Likes</span>
                    <?php if (isset($favEnModelo) && $favEnModelo != null) : ?>
                        <img onclick="location.href = '<?= $_ENV['BASE_URL'] ?>model/favview/id=<?= $modelo->id ?>'" class="favs-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/star-yellow.svg" alt="star">
                        <img class="favs-img" hidden src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/star.svg">
                    <?php else : ?>
                        <img class="favs-img" hidden src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/star-yellow.svg">
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
                <?php 
                if(Utils::isLogged()){
                    $comprobacion_venta = $ventasC -> comprobarVenta($modelo->id);
                }else{
                    $comprobacion_venta = false;
                }
                
                if($comprobacion_venta && $modelo->id_usuario == Utils::isLogged()) :?>

                <div class="model-info-2-btn">
                    <button type="submit" name="action" value="buyNow" class="defaultbtn buynow-btn boxshadow">DOWNLOAD</button>
                </div>

                <?php else:?>

                    <div class="model-info-2-btn">
                        <form action="<?= $_ENV['BASE_URL'] ?>model/buy/id=<?= $modelo->id ?>" method="POST">
                            <button type="submit" name="action" value="buyNow" class="defaultbtn buynow-btn boxshadow">BUY NOW</button>
                        </form>
                    </div>
                <?php endif;?>
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
                <img class="profileimg-comment" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/<?= Utils::isLogged() ? 'user/profilephoto/' . UsuarioController::obtenerFotoUsuario($_SESSION['identity']->id)[0]['foto_perfil']  : '/default/profile.jpg' ?>" alt="">
                <h1 class="username-modelview">You</h1>
            </div>

            <div class="comment-1">
                <form action="<?= $_ENV['BASE_URL'] ?>model/view/comment/id=<?= $modelo->id ?>" id="comment" method="POST">
                    <input type="text" value="<?= $comentario_texto ?? "" ?>" name="comment" id="comment-1" placeholder="Comment...">
                    <button class="defaultbtn boxshadow" type="submit">Comment</button>
                </form>
            </div>
            <span class="red-error" style="position:relative; top: .8rem; color:#FB7676;">
                <?= $message['comment'] === "" ? "" : $error_img . $message['comment']; ?>
                <?php if(isset($_SESSION['esta_reportado'])): ?>
                    <?= $_SESSION['esta_reportado'] === "" ? "" : $error_img . $_SESSION['esta_reportado']; ?>
                <?php endif; ?>
                <?php if(isset($error_reportar_tu_comentario) && $error_reportar_tu_comentario != ""){
                    echo $error_img.$error_reportar_tu_comentario;
                } ?>
                    
            </span>
        </div>
        <?php foreach ($comentarios as $comentario) : ?>
            <div class="cont-comment-2">
                <div class="comment-user-info">
                    <img class="profileimg-comment" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/user/profilephoto/<?=UsuarioController::obtenerFotoUsuario($comentario->getId_usuario())[0]['foto_perfil'] ?>" alt="">
                    <h1 class="username-modelview">
                        <?php if($comentario -> getId_usuario() == Utils::idLoggedUsuario()): ?>
                            You
                        <?php else: ?>
                            <?= Utils::isLogged() && $comentario->getId_usuario() === $_SESSION['identity'] -> id ? "You" : UsuarioController::obtenerNombreUsuario($comentario->getId_usuario())[0]['nombre'] ?>
                        <?php endif; ?>
                    </h1>
                    <span class="comment-date"><?= explode(" ",$comentario -> getFecha_subida())[0] ?></span>
                </div>

                <div class="comment-2-container">
                    <div class="comment-2">
                        <p><?= $comentario->getContenido() ?? "" ?></p>
                    </div>
                    <?php if($comentario -> getId_usuario() != Utils::idLoggedUsuario()): ?>
                        <img onclick="location.href = '<?= $_ENV['BASE_URL'] ?>model/view/comment/report/id=<?= $comentario->getId() ?>'" class="report-flag" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/red-flag.svg" alt="report flag">
                    <?php endif; ?>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
</main>

<script>
    const like = document.getElementsByClassName("likes-img")[1];
    const likesrc1 = document.getElementsByClassName("likes-img")[1].src;
    const likesrc2 = document.getElementsByClassName("likes-img")[0].src;
    
    const fav = document.getElementsByClassName("favs-img")[1];
    const favsrc1 = document.getElementsByClassName("favs-img")[1].src;
    const favsrc2 = document.getElementsByClassName("favs-img")[0].src;


    like.addEventListener("mouseover", function(e){
        e.target.src = likesrc2;
        
    });
    like.addEventListener("mouseout", function(e){
        e.target.src = likesrc1;
    });

    
    fav.addEventListener("mouseover", function(e){
        e.target.src = favsrc2;
        
    });
    fav.addEventListener("mouseout", function(e){
        e.target.src = favsrc1;
    });
</script>

<?php
require_once '../views/layout/footer.php';
?>