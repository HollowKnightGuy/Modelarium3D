
<?php 
$estilos = [ 'profile','models'];
foreach ($estilos as $estilo) :  ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilo ?>.css">
<?php
endforeach;
require_once '../views/layout/header.php';

use Lib\Utils;
use Controllers\UsuarioController;
use Controllers\ModeloController;
use Controllers\VentasController;
use Controllers\LikeController;
use Controllers\FavoritosController;

$usuarioC = new UsuarioController();
$modeloC = new ModeloController();
$ventasC = new VentasController();
$likeC = new LikeController();
$favC = new FavoritosController();

$creador = $usuarioC -> obtenerUsuarioPorId($id_autor);
$modelos_creador = $modeloC -> obtenerModelosUsuario($creador->id);

?>
    <main>
    
        <div class="banner">
            <?php if($creador -> banner == NULL):?>
                <img class="banner-img" src="<?= $_ENV['BASE_URL_PUBLIC']?>img/default/banner.jpg">
            <?php else:?>
                <img class="banner-img" src="<?= $_ENV['BASE_URL_PUBLIC']?>img/user/profilebanner/<?= $creador -> banner?>" alt="<?= $creador -> banner?>">
            <?php endif;?>
            <img class="profile-img" src="<?= $_ENV['BASE_URL_PUBLIC']?>img/user/profilephoto/<?= $creador -> foto_perfil?>" alt="<?= $creador -> foto_perfil?>">
            
            <div class="profile-info">
                <h1><?= $creador->nombre?></h1>
                <p>Joined <?= explode(' ', $creador->fecha_creacion)[0]?></p>
                <p><?= str_replace("ROLE_", "", $creador -> rol)?></p>
            </div>
        </div>


        
        <div class="models">

            <?php foreach ($modelos_creador as $modelo) : ?>
                <?php if(Utils::isLogged()){
                    $likeEnModelo = $likeC->comprobarLike(Utils::idLoggedUsuario(), $modelo->id);
                    $favEnModelo = $favC->comprobarFavorito(Utils::idLoggedUsuario(), $modelo->id);
                }?>
                            <div class="model">
                                <div class="model--model">
                                    <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/models/<?= $modelo->foto_modelo ?>" alt="model">
                                </div>

                                <div class="model--modelinfo">
                                    <div class="infomodel">
                                        <div class="model--title"><?= $modelo->titulo ?></div>
                                        <div class="model--author ">Author: <a href="profile/author/id=<?= $modelo->id_usuario ?>" class="linkpurple"><?= $usuarioC->obtenerUsuarioPorId($modelo->id_usuario)->nombre ?></a></div>
                                    </div>
                                    <div class="model--likesfavs textshadowlight">
                                    <div class="model--likes" onclick="location.href = '<?= $_ENV['BASE_URL'] ?>profile/author/like/id=<?= $modelo -> id ?>'">
                                        <?php if (isset($likeEnModelo) && $likeEnModelo != null) : ?>
                                            <img class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart-red.svg" alt="heart">
                                        <?php else : ?>
                                            <img class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart.svg" alt="heart">
                                        <?php endif; ?>
                                        <span><?= $modelo->num_likes === null ? 0 : $modelo->num_likes ?></span>
                                    </div>
                                    <div class="model--favs" onclick="location.href = '<?= $_ENV['BASE_URL'] ?>profile/author/fav/id=<?= $modelo -> id ?>'">
                                        <?php if (isset($favEnModelo) && $favEnModelo != null) : ?>
                                            <img class="favs-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/star-yellow.svg" alt="star">

                                        <?php else : ?>
                                            <img class="favs-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/star.svg" alt="star">
                                        <?php endif; ?>

                                        <span><?= $modelo->num_favs === null ? 0 : $modelo->num_favs ?></span>
                                    </div>
                                </div>
                                </div>
                                <div class="profile-cards-button">
                                    <div class="model--seebtn">
                                            <button class="boxshadow defaultbtn transition profile-button" onclick="location.href = '<?= $_ENV['BASE_URL'] ?>models/view/id=<?= $modelo->id ?>'">SEE MORE</button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>

        </div>
    </main>

    <?php
require_once '../views/layout/footer.php';
?>