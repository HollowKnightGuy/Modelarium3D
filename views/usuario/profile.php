<?php
$estilos = ['profile', 'models'];
foreach ($estilos as $estilo) :  ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilo ?>.css">
<?php
endforeach;
require_once '../views/layout/header.php';

use Controllers\UsuarioController;

$usuarioC = new UsuarioController();

if (isset($_SESSION['identity'])) {
    $userdata = $usuarioC->obtenerUsuario($_SESSION['identity']->email);
}
?>

<main>
    <div class="banner">
        <?php if($userdata->banner == NULL){$route = $_ENV['BASE_URL_PUBLIC']."img/default/banner.jpg";}
        else{$route = $_ENV['BASE_URL_PUBLIC']."img/user/profilebanner/". $userdata->banner;}?>
        <img class="banner-img" src="<?= $route ?>" alt="banner">
        <div class="profile-options">

            <img class="profile-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/user/profilephoto/<?= $userdata->foto_perfil; ?>" alt="profile">
        </div>
        <div class="profile-creator-gear">
            <div class="profile-creator-div">

                <!-- TODO NO lo está cogiendo bien -->
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

        <div class="profile-info">
            <h1><?= $userdata->nombre ?></h1>
            <p><?= 'Joined ', explode(' ', $userdata->fecha_creacion)[0] ?></p>
            <p><?= explode('_', $userdata->rol)[1]; ?></p>
            <p style="color:black"><?= $userdata->descripcion ?></p>

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
                <article class="profile-section profile-section-models">
                    <div class="model">
                        <div class="model--model">
                            <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/models/arcade.png" alt="model">
                        </div>

                        <div class="model--modelinfo">
                            <div class="infomodel">
                                <div class="model--title">Arcade Machine</div>
                                <div class="model--author ">Author: <a href="author.html" class="linkpurple">Pablo Cid</a></div>
                            </div>
                            <div class="model--likesfavs textshadowlight">
                                <div class="model--likes">
                                    <img class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart.svg" alt="heart">
                                    <span>40</span>
                                </div>
                                <div class="model--favs">
                                    <img class="favs-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/star.svg" alt="heart">
                                    <span>40</span>
                                </div>
                            </div>
                        </div>
                        <div class="profile-cards-button">
                            <div class="model--seebtn">
                                <button class="boxshadow defaultbtn transition profile-button" onclick="location.href = './modelview.html' ">DOWNLOAD</button>
                            </div>

                        </div>
                    </div>
                </article>

                <article class="profile-section profile-section-liked none">
                    <div class="model">
                        <div class="model--model">
                            <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/models/cactus.png" alt="model">
                        </div>

                        <div class="model--modelinfo">
                            <div class="infomodel">
                                <div class="model--title">Cactus</div>
                                <div class="model--author ">Author: <a href="author.html" class="linkpurple">Pablo Cid</a></div>
                            </div>
                            <div class="model--likesfavs textshadowlight">
                                <div class="model--likes">
                                    <img class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart-red.svg" alt="heart">
                                    <span>40</span>
                                </div>
                                <div class="model--favs">
                                    <img class="favs-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/star.svg" alt="heart">
                                    <span>40</span>
                                </div>
                            </div>
                        </div>

                        <div class="buy">
                            <div class="model--seebtn">
                                <button class="boxshadow defaultbtn transition" onclick="location.href = '<?= $_ENV['BASE_URL'] ?>/models/view'">SEE MORE</button>
                            </div>
                            <div class="model--price textshadowlight">
                                <span>4</span><span class="price-snumber">,99€</span>
                            </div>
                        </div>
                    </div>
                </article>

                <article class="profile-section profile-section-favorites none">
                    <div class="model">
                        <div class="model--model">
                            <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/models/ipad.png" alt="model">
                        </div>

                        <div class="model--modelinfo">
                            <div class="infomodel">
                                <div class="model--title">Ipad</div>
                                <div class="model--author ">Author: <a href="author.html" class="linkpurple">Pablo Cid</a></div>
                            </div>
                            <div class="model--likesfavs textshadowlight">
                                <div class="model--likes">
                                    <img class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/heart.svg" alt="heart">
                                    <span>40</span>
                                </div>
                                <div class="model--favs">
                                    <img class="favs-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/star-yellow.svg" alt="heart">
                                    <span>40</span>
                                </div>
                            </div>
                        </div>

                        <div class="buy">
                            <div class="model--seebtn">
                                <button class="boxshadow defaultbtn transition" onclick="location.href = '<?= $_ENV['BASE_URL'] ?>models/view'">SEE MORE</button>
                            </div>
                            <div class="model--price textshadowlight">
                                <span>4</span><span class="price-snumber">,99€</span>
                            </div>
                        </div>
                    </div>
                </article>

                <?php if (isset($userdata->rol) && $userdata->rol == 'ROLE_CREATOR') : ?>

                    <article class="profile-section profile-section-created none">
                        <div class="model">
                            <div class="model--model">
                                <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/models/sofa.png" alt="model">
                            </div>

                            <div class="model--modelinfo">
                                <div class="infomodel">
                                    <div class="model--title">Lowpoly sofa</div>
                                    <div class="model--author ">Author: <a href="author.html" class="linkpurple">You</a></div>
                                </div>
                                <div class="model--likesfavs textshadowlight">
                                    <div class="model--likes">
                                        <img class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/hidden.svg" alt="heart">

                                    </div>
                                    <div class="model--favs">
                                        <img class="favs-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/trashcan.svg" alt="heart">

                                    </div>
                                </div>
                            </div>
                            <div class="profile-cards-button">
                                <div class="model--seebtn">
                                    <button class="boxshadow defaultbtn transition profile-button" onclick="location.href = '<?= $_ENV['BASE_URL'] ?>/models/create' ">EDIT</button>
                                </div>

                            </div>
                        </div>
                    </article>

                    <article class="profile-section profile-section-hidden none">
                        <div class="model">
                            <div class="model--model">
                                <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/models/chair.png" alt="model">
                            </div>

                            <div class="model--modelinfo">
                                <div class="infomodel">
                                    <div class="model--title">Desktop Chair</div>
                                    <div class="model--author ">Author: <a href="author.html" class="linkpurple">You</a></div>
                                </div>
                                <div class="model--likesfavs textshadowlight">
                                    <div class="model--likes">
                                        <img class="likes-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/visible.svg" alt="heart">

                                    </div>
                                    <div class="model--favs">
                                        <img class="favs-img" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/icons/trashcan.svg" alt="heart">
BASE_URL_PUBLIC
                                    </div>
                                </div>
                            </div>
                            <div class="profile-cards-button">
                                <div class="model--seebtn">
                                    <button class="boxshadow defaultbtn transition profile-button" onclick="location.href = '<?= $_ENV['BASE_URL'] ?>models/edit' ">EDIT</button>
                                </div>

                            </div>
                        </div>
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


    <?php if (isset($userdata->rol) && $userdata->rol == 'ROLE_CREATOR') : ?>

        function changePState(s1, s2, s3, s4, s5) {
            profileSections[0].style.display = s1;
            profileSections[1].style.display = s2;
            profileSections[2].style.display = s3;
            profileSections[3].style.display = s4;
            profileSections[4].style.display = s5;


            if (s1 !== "none") {
                changePLinktates(lastclickedp, 0);
            } else if (s2 !== "none") {
                changePLinktates(lastclickedp, 1);
            } else if (s3 !== "none") {
                changePLinktates(lastclickedp, 2);
            } else if (s4 !== "none") {
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

    <?php endif; ?>
</script>