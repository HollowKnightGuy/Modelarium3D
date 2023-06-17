<?php
$estilos = ['profile', 'models'];
foreach ($estilos as $estilo) :  ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilo ?>.css">
<?php
endforeach;
require_once '../views/layout/header.php';

use Controllers\UsuarioController;
use Controllers\ModeloController;
use Controllers\VentasController;
use Controllers\LikeController;
use Controllers\FavoritosController;
use Lib\Utils;

$usuarioC = new UsuarioController();
$modeloC = new ModeloController();
$ventasC = new VentasController();
$likeC = new LikeController();
$favC = new FavoritosController();

$modelosComprados = $ventasC->obtenerComprasUsuario(Utils::idLoggedUsuario());
$modelosLikeUsuario = $likeC->obtenerModelosLiked(Utils::idLoggedUsuario());
$modelosFavUsuario = $favC->obtenerModelosFav(Utils::idLoggedUsuario());
$modelosUsuario = $modeloC->obtenerModelosUsuarioNP(Utils::idLoggedUsuario());
$modelosPrivadosUsuario = $modeloC->obtenerModelosPrivadosUsuario(Utils::idLoggedUsuario());
if (Utils::isLogged()) {
    $userdata = $usuarioC->obtenerUsuario($_SESSION['identity']->email);
}
$error_img = '<img src=' . $_ENV['BASE_URL_PUBLIC'] . 'img/icons/error.svg alt=error>';
$tick_img = '<img src=' . $_ENV['BASE_URL_PUBLIC'] . 'img/icons/tick-normal.svg alt=succesfull.svg>';
?>
<title>Modelarium3D - Profile</title>

<main>
    <div class="banner">
        <?php if ($userdata->banner == NULL) {
            $route = $_ENV['BASE_URL_PUBLIC'] . "img/default/banner.jpg";
        } else {
            $route = $_ENV['BASE_URL_PUBLIC'] . "img/user/profilebanner/" . $userdata->banner;
        } ?>
        <img class="banner-img" src="<?= $route ?>" alt="banner">
        <div class="profile-options">

            <img class="profile-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/user/profilephoto/<?= $userdata->foto_perfil; ?>" alt="profile">
        </div>
        <?php if (!Utils::isAdmin()) : ?>
            <div class="profile-creator-gear">
                <div class="profile-creator-div">

                    <?php if (isset($userdata->rol) && $userdata->rol == 'ROLE_USER') : ?>

                        <button class="profile-creator-button transition textshadow boxshadow defaultbtn" onclick="location.href ='<?= $_ENV['BASE_URL'] ?>profile/becreator'">
                            Be Creator
                            <img class="model-creator-svg" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/cube.svg" alt="model">
                        </button>
                    <?php endif; ?>
                </div>
                <div class="profile-gear-button">
                    <a href="<?= $_ENV['BASE_URL'] ?>profile/settings">
                        <img class="gear-svg transition" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/gear.svg" alt="gear">
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <div class="profile-info">
            <h1><?= $userdata->nombre ?></h1>
            <p><?= 'Joined ', explode(' ', $userdata->fecha_creacion)[0] ?></p>
            <p><?= explode('_', $userdata->rol)[1]; ?></p>
            <p style="color:black"><?= $userdata->descripcion ?></p>
            <?php if (isset($_SESSION['peticion_mandada']) && $_SESSION['peticion_mandada']) :
                $_SESSION['peticion_mandada'] = false; ?>
                <span class="red-error" style="color:red;display:flex;align-items:center;gap:.7rem;font-size:var(--fs-200);"><?= $error_img . "A creator request is already sended" ?></span>
            <?php endif ?>
            <?php if (isset($_SESSION['peticion_modelo_exitosa']) && $_SESSION['peticion_modelo_exitosa']) :
                $_SESSION['peticion_modelo_exitosa'] = false; ?>
                <span class="red-error" style="color:#33a115;display:flex;align-items:center;gap:.7rem;font-size:var(--fs-200);"><?= $tick_img . "Model request sended succesfully" ?></span>
            <?php endif ?>
            <?php if (isset($_SESSION['peticion_creador_exitosa']) && $_SESSION['peticion_creador_exitosa']) :
                $_SESSION['peticion_creador_exitosa'] = false; ?>
                <span class="red-error" style="color:#33a115;display:flex;align-items:center;gap:.7rem;font-size:var(--fs-200);"><?= $tick_img . "Creator request sended succesfully" ?></span>
            <?php endif ?>
        </div>
    </div>


    <div class="profile-content">
        <div class="profile-categories">
            <ul>
                <li>
                    <a class="profile_link transition" onclick="changePState('flex','none','none','none','none')">
                        <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/model.svg" alt="model">
                        <span>Models</span>
                    </a>
                </li>
                <li>
                    <a class="profile_link transition none" onclick="changePState('none','none','flex','none','none')">
                        <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart.svg" alt="heart">
                        <span>Liked</span>
                    </a>
                </li>
                <li>
                    <a class="profile_link transition none" onclick="changePState('none','none','none','flex','none')">
                        <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/star.svg" alt="">
                        <span>Favorites</span>
                    </a>
                </li>

                <?php if (isset($userdata->rol) && $userdata->rol == 'ROLE_CREATOR') : ?>

                    <li>
                        <a class="profile_link transition none" onclick="changePState('none','flex','none','none','none')">
                            <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/created.svg" alt="created">
                            <span>Created</span>
                        </a>
                    </li>

                    <li>
                        <a class="profile_link transition none" onclick="changePState('none','none','none','none','flex')">
                            <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/hidden.svg" alt="hidden">
                            <span>Hidden</span>
                        </a>
                    </li>

                    <li>
                        <a class="profile_link transition none" href="<?= $_ENV['BASE_URL'] ?>models/create">
                            <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/new-model.svg" alt="hidden">
                            <span>New Model</span>
                        </a>
                    </li>

                <?php endif; ?>

            </ul>
        </div>
        <div class="profile-models">

            <section class="models">

                <?php
                if (isset($modelosComprados) && count($modelosComprados) > 0) : ?>
                    <article class="profile-section profile-section-models">
                        <?php foreach ($modelosComprados as $modelo) :
                            if (Utils::isLogged()) {
                                $likeEnModelo = $likeC->comprobarLike(Utils::idLoggedUsuario(), $modelo->id);
                                $favEnModelo = $favC->comprobarFavorito(Utils::idLoggedUsuario(), $modelo->id);
                            }
                        ?>
                            <div class="model">
                                <div class="model--model">
                                    <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/models/<?= $modelo->foto_modelo ?>" alt="model">
                                </div>

                                <div class="model--modelinfo">
                                    <div class="infomodel">
                                        <div class="model--title"><?= $modelo->titulo ?></div>
                                        <div class="model--author ">Author: <a href="<?= $_ENV['BASE_URL'] ?>profile/author/id=<?= $modelo->id_usuario ?>" class="linkpurple"><?= $usuarioC->obtenerUsuarioPorId($modelo->id_usuario)->nombre ?></a></div>
                                    </div>
                                    <div class="model--likesfavs textshadowlight">
                                        <div class="model--likes" onclick="location.href = '<?= $_ENV['BASE_URL'] ?>profile/like/id=<?= $modelo->id ?>'">
                                            <?php if (isset($likeEnModelo) && $likeEnModelo != null) : ?>
                                                <img class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart-red.svg" alt="heart">
                                            <?php else : ?>
                                                <img class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart.svg" alt="heart">
                                            <?php endif; ?>
                                            <span><?= $modelo->num_likes === null ? 0 : $modelo->num_likes ?></span>

                                        </div>
                                        <div class="model--favs" onclick="location.href = '<?= $_ENV['BASE_URL'] ?>profile/fav/id=<?= $modelo->id ?>'">
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
                    </article>
                <?php else : ?>
                    <article class="profile-section profile-section-models">
                        <h1 class="purple">You haven't bought any model yet</h1>
                    </article>
                <?php endif; ?>

                <?php if (!empty($modelosLikeUsuario)) : ?>
                    <article class="profile-section profile-section-models none">
                        <?php foreach ($modelosLikeUsuario as $item) :
                            $id_modelo = $item->id_modelo;
                            $modelo = $modeloC->obtenerModeloPorId($id_modelo);
                            if (Utils::isLogged()) {
                                $likeEnModelo = $likeC->comprobarLike(Utils::idLoggedUsuario(), $modelo->id);
                                $favEnModelo = $favC->comprobarFavorito(Utils::idLoggedUsuario(), $modelo->id);
                            }
                        ?>
                            <div class="model">
                                <div class="model--model">
                                    <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/models/<?= $modelo->foto_modelo ?>" alt="model">
                                </div>

                                <div class="model--modelinfo">
                                    <div class="infomodel">
                                        <div class="model--title"><?= $modelo->titulo ?></div>
                                        <div class="model--author ">Author: <a href="<?= $_ENV['BASE_URL'] ?>profile/author/id=<?= $modelo->id_usuario ?>" class="linkpurple"><?= $usuarioC->obtenerUsuarioPorId($modelo->id_usuario)->nombre ?></a></div>
                                    </div>
                                    <div class="model--likesfavs textshadowlight">
                                        <div class="model--likes" onclick="location.href = '<?= $_ENV['BASE_URL'] ?>profile/like/id=<?= $modelo->id ?>'">
                                            <?php if (isset($likeEnModelo) && $likeEnModelo != null) : ?>
                                                <img class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart-red.svg" alt="heart">
                                            <?php else : ?>
                                                <img class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart.svg" alt="heart">
                                            <?php endif; ?>
                                            <span><?= $modelo->num_likes === null ? 0 : $modelo->num_likes ?></span>

                                        </div>
                                        <div class="model--favs" onclick="location.href = '<?= $_ENV['BASE_URL'] ?>profile/fav/id=<?= $modelo->id ?>'">
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
                    </article>
                <?php else : ?>
                    <article class="profile-section profile-section-models none">
                        <h1 class="purple">There is no models marked as Liked</h1>
                    </article>
                <?php endif; ?>


                <?php

                if (!empty($modelosFavUsuario)) : ?>
                    <article class="profile-section profile-section-models none">
                        <?php foreach ($modelosFavUsuario as $item) :
                            $id_modelo = $item->id_modelo;
                            $modelo = $modeloC->obtenerModeloPorId($id_modelo);
                            if (Utils::isLogged()) {
                                $likeEnModelo = $likeC->comprobarLike(Utils::idLoggedUsuario(), $modelo->id);
                                $favEnModelo = $favC->comprobarFavorito(Utils::idLoggedUsuario(), $modelo->id);
                            }
                        ?>
                            <div class="model">
                                <div class="model--model">
                                    <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/models/<?= $modelo->foto_modelo ?>" alt="model">
                                </div>

                                <div class="model--modelinfo">
                                    <div class="infomodel">
                                        <div class="model--title"><?= $modelo->titulo ?></div>
                                        <div class="model--author ">Author: <a href="<?= $_ENV['BASE_URL'] ?>profile/author/id=<?= $modelo->id_usuario ?>" class="linkpurple"><?= $usuarioC->obtenerUsuarioPorId($modelo->id_usuario)->nombre ?></a></div>
                                    </div>
                                    <div class="model--likesfavs textshadowlight">
                                        <div class="model--likes" onclick="location.href = '<?= $_ENV['BASE_URL'] ?>profile/like/id=<?= $modelo->id ?>'">
                                            <?php if (isset($likeEnModelo) && $likeEnModelo != null) : ?>
                                                <img class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart-red.svg" alt="heart">
                                            <?php else : ?>
                                                <img class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart.svg" alt="heart">
                                            <?php endif; ?>
                                            <span><?= $modelo->num_likes === null ? 0 : $modelo->num_likes ?></span>

                                        </div>
                                        <div class="model--favs" onclick="location.href = '<?= $_ENV['BASE_URL'] ?>profile/fav/id=<?= $modelo->id ?>'">
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
                    </article>
                <?php else : ?>
                    <article class="profile-section profile-section-models none">
                        <h1 class="purple">There is no models marked as favorites</h1>
                    </article>
                <?php endif; ?>

                <?php
                if (isset($modelosUsuario) && count($modelosUsuario) > 0) : ?>
                    <article class="profile-section profile-section-models none">
                        <?php foreach ($modelosUsuario as $modelo) :
                        ?>
                            <div class="model">
                                <div class="model--model">
                                    <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/models/<?= $modelo->foto_modelo ?>" alt="model">
                                </div>

                                <div class="model--modelinfo">
                                    <div class="infomodel">
                                        <div class="model--title"><?= $modelo->titulo ?></div>
                                        <div class="model--author ">Author: <a href="<?= $_ENV['BASE_URL'] ?>profile/author/id=<?= $modelo->id_usuario ?>" class="linkpurple"><?= $usuarioC->obtenerUsuarioPorId($modelo->id_usuario)->nombre ?></a></div>
                                    </div>
                                    <div class="model--likesfavs textshadowlight">
                                        <div class="model--likes">
                                            <a href="<?= $_ENV['BASE_URL'] ?>profile/visible/id=<?= $modelo->id ?>">
                                                <img class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/visible.svg" alt="heart">
                                            </a>
                                        </div>
                                        <div class="model--favs">
                                            <a href="<?= $_ENV['BASE_URL'] ?>creator/deleteModel/id=<?= $modelo->id ?>">
                                                <img class="favs-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/trashcan.svg" alt="heart">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-cards-button">
                                    <div class="model--seebtn">
                                        <button class="boxshadow defaultbtn transition profile-button" onclick="location.href = '<?= $_ENV['BASE_URL'] ?>models/edit?id=<?= $modelo->id ?>'">EDIT</button>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </article>
                <?php else : ?>
                    <article class="profile-section profile-section-models none">
                        <h1 class="purple">You haven't created any model yet or are marked as hidden</h1>
                    </article>
                <?php endif; ?>

                <?php if (!empty($modelosPrivadosUsuario)) : ?>


                    <article class="profile-section profile-section-models none">
                        <?php foreach ($modelosPrivadosUsuario as $modelo) : ?>
                            <div class="model">
                                <div class="model--model">
                                    <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/models/<?= $modelo->getFoto_modelo() ?>" alt="model">
                                </div>

                                <div class="model--modelinfo">
                                    <div class="infomodel">
                                        <div class="model--title"><?= $modelo->getTitulo() ?></div>
                                        <div class="model--author ">Author: <a href="<?= $_ENV['BASE_URL'] ?>profile/author/id=<?= $modelo->getId_usuario() ?>" class="linkpurple"><?= $usuarioC->obtenerUsuarioPorId($modelo->getId_usuario())->nombre ?></a></div>
                                    </div>
                                    <div class="model--likesfavs textshadowlight">
                                        <div class="model--likes">
                                            <a href="<?= $_ENV['BASE_URL'] ?>profile/visible/id=<?= $modelo->getId() ?>">
                                                <img class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/hidden.svg" alt="heart">
                                            </a>
                                        </div>
                                        <div class="model--favs">
                                            <a href="<?= $_ENV['BASE_URL'] ?>creator/deleteModel/id=<?= $modelo->getId() ?>">
                                                <img class="favs-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/trashcan.svg" alt="heart">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-cards-button">
                                    <div class="model--seebtn">
                                        <button class="boxshadow defaultbtn transition profile-button" onclick="location.href = '<?= $_ENV['BASE_URL'] ?>models/edit/id=<?= $modelo->getId() ?>'">EDIT</button>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </article>
                <?php else : ?>
                    <article class="profile-section profile-section-models none">
                        <h1 class="purple">There is no models Hidden</h1>
                    </article>
                <?php endif; ?>
            </section>
        </div>
</main>
<script>
    const profileSections = document.getElementsByClassName("profile-section");
    const pLinks = document.getElementsByClassName("profile_link");


    // FUNCIONALITY OF THE PROFILE SETTINGS
    let lastclickedp



    function changePLinktates(link, newlink) {
        if (typeof link != "undefined") {
            link.classList.toggle("plink-clicked")
        }
        lastclickedp = pLinks[newlink];
        pLinks[newlink].classList.toggle("plink-clicked");

    }


    <?php if (isset($userdata->rol) && $userdata->rol === 'ROLE_CREATOR') :
    ?>

        function changePState(s1, s2, s3, s4, s5) {
            profileSections[0].style.display = s1;
            profileSections[1].style.display = s3;
            profileSections[2].style.display = s4;
            profileSections[3].style.display = s2;
            profileSections[4].style.display = s5;


            if (s1 !== "none") {
                changePLinktates(lastclickedp, 0);
            } else if (s3 !== "none") {
                changePLinktates(lastclickedp, 1);
            } else if (s4 !== "none") {
                changePLinktates(lastclickedp, 2);
            } else if (s2 !== "none") {
                changePLinktates(lastclickedp, 3);
            } else if (s5 !== "none") {
                changePLinktates(lastclickedp, 4);
            }
        }
    <?php else : ?>

        function changePState(s1, s2, s3, s4, s5) {
            profileSections[0].style.display = s1;
            profileSections[1].style.display = s3;
            profileSections[2].style.display = s4;


            if (s1 !== "none") {
                changePLinktates(lastclickedp, 0);
            } else if (s3 !== "none") {
                changePLinktates(lastclickedp, 1);
            } else if (s4 !== "none") {
                changePLinktates(lastclickedp, 2);
            }
        }

    <?php   endif; ?>
    <?php if (isset($favs) && $favs) : ?>
        changePState('none', 'none', 'none', 'flex', 'none');
        <?php unset($favs) ?>
    <?php endif; ?>
    <?php if (isset($liked) && $liked) : ?>
        changePState('none', 'none', 'flex', 'none', 'none');
        <?php unset($liked) ?>
                
    <?php endif; ?>
</script>


<?php
require_once '../views/layout/footer.php';
?>