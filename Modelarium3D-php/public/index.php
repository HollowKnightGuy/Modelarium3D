<?php
session_start();

require_once __DIR__ . '../../vendor/autoload.php';

use Dotenv\Dotenv;
use Lib\ResponseHttp;
use Lib\Router;
use Controllers\UsuarioController;
use Controllers\HomeController;
use Controllers\ModeloController;
use Controllers\PeticionController;
use Controllers\LikeController;
use Controllers\FavoritosController;
use Controllers\ComentariosController;
use Controllers\InterController;
use Controllers\VentasController;
use Lib\Utils;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

?>
<?php if (Utils::isLogged() && $_SESSION['identity']->rol === 'ROLE_ADMIN') : ?>
    <script type='module' src='<?= $_ENV["BASE_URL_PUBLIC"] ?>js/adminmain.js' defer></script>
<?php else : ?>
    <script type='module' src='<?= $_ENV["BASE_URL_PUBLIC"] ?>js/main.js' defer></script>

<?php endif; ?>

<?php


Router::add('GET', '/', function () {
    (new HomeController())->index();
});



Router::add('GET', '/login', function () {
    (new UsuarioController())->login();
});

Router::add('POST', '/login', function () {
    (new UsuarioController())->login();
});



Router::add('GET', '/logout', function () {
    (new UsuarioController())->cerrar_sesion();
});



Router::add('GET', '/register', function () {
    (new UsuarioController())->registro();
});

Router::add('POST', '/register', function () {
    (new UsuarioController())->registro();
});



Router::add('GET', '/profile', function () {
    (new UsuarioController())->perfil();
});

Router::add('GET', '/profile/liked', function () {
    (new UsuarioController())->perfil(true);
});

Router::add('GET', '/profile/favs', function () {
    (new UsuarioController())->perfil(false, true);
});

Router::add('GET', '/profile/settings', function () {
    (new UsuarioController())->update();
});

Router::add('POST', '/profile/settings', function () {
    (new UsuarioController())->update();
});

Router::add('GET', '/profile/settings/faq', function () {
    (new UsuarioController())->update(null, false, true);
});

Router::add('GET', '/userprofile/update', function () {
    (new UsuarioController())->update();
});

Router::add('POST', '/userprofile/update', function () {
    (new UsuarioController())->update();
});


Router::add('GET', '/model/author/id=:id', function (int $id) {
    (new UsuarioController())->autor($id);
});

Router::add('GET', '/home', function () {
    (new HomeController())->index();
});

Router::add('GET', '/models', function () {
    (new ModeloController())->showAll();
});

Router::add('GET', '/models/create', function () {
    (new ModeloController())->crear();
});


Router::add('GET', '/models/view/id=:id', function (int $id) {
    (new ModeloController())->mostrarModelo($id);
});

Router::add('POST', '/model/buy/id=:id', function (int $id) {
    (new VentasController())->comprar($id);
});

Router::add('GET', '/model/view/download/id=:id', function (int $id) {
    (new ModeloController())->descargar($id);
});

Router::add('GET', '/model/like/id=:id', function (int $id) {
    (new LikeController())->like($id);
});

Router::add('GET', '/model/fav/id=:id', function (int $id) {
    (new FavoritosController())->favorito($id);
});

Router::add('POST', '/models/search', function (){
    (new ModeloController()) -> buscar();
});


Router::add('GET', '/model/likeview/id=:id', function (int $id) {
    (new LikeController())->like($id, true);
});

Router::add('GET', '/model/favview/id=:id', function (int $id) {
    (new FavoritosController())->favorito($id, true);
});

Router::add('POST', '/model/view/comment/id=:id', function (int $id) {
    (new ComentariosController())->comentar($id);
});

Router::add('GET', '/model/view/comment/report/id=:id', function (int $id) {
    (new PeticionController())->solicitud(null, 'rep', $id);
});



Router::add('GET', '/contact', function () {
    (new HomeController())->contacto();
});

Router::add('POST', '/contact', function () {
    (new HomeController())->contacto();
});

Router::add('GET', '/aboutus', function () {
    (new HomeController())->aboutus();
});

Router::add('GET', 'profile/becreator', function () {
    (new PeticionController())->serCreador();
});

Router::add('POST', 'profile/becreator', function () {
    (new PeticionController())->serCreador();
});

Router::add('GET', 'profile/author/id=:id', function (int $id) {
    (new UsuarioController())->autor($id);
});

Router::add('GET', 'profile/visible/id=:id', function (int $id) {
    (new ModeloController())->cambiarPrivado($id);
});

Router::add('GET', 'profile/author/like/id=:id', function (int $id) {
    (new LikeController())->like($id, false ,$autor = true);
});

Router::add('GET', 'profile/author/fav/id=:id', function (int $id) {
    (new FavoritosController())->favorito($id, false ,$autor = true);
});

Router::add('GET', 'profile/like/id=:id', function (int $id) {
    (new LikeController())->like($id, false , false, true);
});

Router::add('GET', 'profile/fav/id=:id', function (int $id) {
    (new FavoritosController())->favorito($id, false , false, true);
});


//CREADOR

Router::add('GET', 'creator/request', function () {
    (new PeticionController())->solicitud();
});

Router::add('POST', 'creator/request', function () {
    (new PeticionController())->solicitud();
});

Router::add('GET', 'creator/deleteModel/id=:id', function (int $id) {
    (new ModeloController())->borrar($id);
    Utils::irProfile();
});

Router::add('GET', '/models/edit?id=:id', function (int $id) {
    (new ModeloController())->editar($id);
});

Router::add('POST', '/models/edit?id=:id', function (int $id) {
    (new ModeloController())->editar($id);
});



// //ADMINISTRADOR

Router::add('GET', 'admin/requests', function () {
    (new PeticionController())->solicitud();
});

Router::add('POST', 'admin/requests', function () {
    (new PeticionController())->solicitud();
});

Router::add('GET', 'admin/requests/creators/id=:id', function (int $id) {
    (new PeticionController())->obtenerCreador($id);
});

Router::add('GET', 'admin/requests/comments/id=:id', function (int $id) {
    (new PeticionController())->obtenerComentario($id);
});

Router::add('GET', 'admin/users', function () {
    (new UsuarioController())->gestionUsuarios();
});

Router::add('POST', 'admin/users', function () {
    (new UsuarioController())->gestionUsuarios();
});

Router::add('GET', 'admin/createuser', function () {
    (new UsuarioController())->registro();
});

Router::add('POST', 'admin/createuser', function () {
    (new UsuarioController())->registro();
});

Router::add('GET', 'admin/deleteuser/id=:id', function (int $id) {
    (new InterController())->borrarUsuario($id);
});

Router::add('GET', 'admin/updateuser/id=:id', function (int $id) {
    (new UsuarioController())->update($id);
});

Router::add('POST', 'admin/updateuser/id=:id', function (int $id) {
    (new UsuarioController())->update($id);
});




Router::add('GET', 'admin/denyrequest/MO/id=:id', function (int $id) {
    (new PeticionController())->rechazarSolicitud('MO', $id);
});

Router::add('GET', 'admin/acceptrequest/MO/id=:id', function (int $id) {
    (new PeticionController())->aceptarSolicitud('MO', $id);
});


Router::add('GET', 'admin/denyrequest/BC/id=:id', function ( int $id) {
    (new PeticionController())->rechazarSolicitud('BC', $id);
});
Router::add('GET', 'admin/acceptrequest/BC/id=:id', function (int $id) {
    (new PeticionController())->aceptarSolicitud('BC', $id);
});


Router::add('GET', 'admin/denyrequest/CO/id=:id', function (int $id) {
    (new PeticionController())->rechazarSolicitud('CO', $id);
});
Router::add('GET', 'admin/acceptrequest/CO/id=:id', function (int $id) {
    (new PeticionController())->aceptarSolicitud('CO', $id);
});





Router::dispatch();

?>



<script>
    <?php if (Utils::isLogged() && $_SESSION['identity'] !== false) : ?>
        const backAccountLink = document.getElementById("back-account-responsive-link");
        const accountLink = document.getElementById("account-responsive-link");

        accountLink.addEventListener("click", function() {
            document.getElementById("general-menu-section").style.display = "none";
            document.getElementById("responsive-menu-profilesection").style.display = "block";
        });

        backAccountLink.addEventListener("click", function() {
            document.getElementById("general-menu-section").style.display = "block";
            document.getElementById("responsive-menu-profilesection").style.display = "none";
        });

    <?php endif; ?> 
</script>