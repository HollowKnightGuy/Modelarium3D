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



$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

?>
<?php if (isset($_SESSION['identity']) && $_SESSION['identity']->rol === 'ROLE_ADMIN') : ?>
    <script type='module' src='<?= $_ENV["BASE_URL_PUBLIC"] ?>js/adminmain.js' defer></script>
<?php else : ?>
    <script type='module' src='<?= $_ENV["BASE_URL_PUBLIC"] ?>js/main.js' defer></script>

<?php endif; ?>

<?php


Router::add('GET', '/', function () {
    (new HomeController())->IrHabitacion();
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

// Router::add('GET','/usuario/getall',function(){
//     (new UsuarioController()) -> getall();
// });

Router::add('GET', '/profile/settings', function () {
    (new UsuarioController())->update();
});

Router::add('POST', '/profile/settings', function () {
    (new UsuarioController())->update();
});

Router::add('GET', '/userprofile/update', function () {
    (new UsuarioController())->update();
});

Router::add('POST', '/userprofile/update', function () {
    (new UsuarioController())->update();
});


Router::add('GET', '/model/author', function () {
    (new UsuarioController())->autor();
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

Router::add('GET', '/models/edit', function () {
    (new ModeloController())->editar();
});


Router::add('GET', '/models/view/id=:id', function (int $id) {
    (new ModeloController())->mostrarModelo($id);
});

Router::add('POST', '/modelbuy/id=:id', function (int $id) {
    var_dump($id); die;
    (new ModeloController())->mostrarModelo($id);
});

Router::add('GET', '/model/like/id=:id', function (int $id) {
    (new LikeController())->like($id);
});

Router::add('GET', '/model/fav/id=:id', function (int $id) {
    (new FavoritosController())->favorito($id);
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



Router::add('GET', '/contact', function () {
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

//CREADOR

Router::add('GET', 'creator/request', function () {
    (new PeticionController())->solicitud();
});

Router::add('POST', 'creator/request', function () {
    (new PeticionController())->solicitud();
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
    (new UsuarioController())->borrarUsuario($id);
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


Router::add('GET', 'admin/denytrequest/CO/id=:id', function (int $id) {
    (new PeticionController())->rechazarSolicitud('CO', $id);
});
Router::add('GET', 'admin/acceptrequest/CO/id=:id', function (int $id) {
    (new PeticionController())->aceptarSolicitud('CO', $id);
});




Router::dispatch();

?>



<script>
    <?php if (isset($_SESSION['identity']) && $_SESSION['identity'] !== false) : ?>
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