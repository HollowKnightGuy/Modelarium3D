<?php
session_start();

require_once __DIR__ . '../../vendor/autoload.php';

use Dotenv\Dotenv;
use Lib\ResponseHttp;
use Lib\Router;
use Controllers\UsuarioController;
use Controllers\HomeController;
use Controllers\ModeloController;



$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

?>
<?php if (isset($_SESSION['identity']) && $_SESSION['identity']->rol === 'ROLE_ADMIN') : ?>
    <script type='module' src='<?= $_ENV["BASE_URL"] ?>js/adminmain.js' defer></script>
<?php else : ?>
    <script type='module' src='<?= $_ENV["BASE_URL"] ?>js/main.js' defer></script>

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
    (new UsuarioController())->perfilajustes();
});

Router::add('GET', '/profile/becreator', function () {
    (new UsuarioController())->sercreador();
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


Router::add('GET', '/models/view', function () {
    (new ModeloController())->mostrarModelo();
});

Router::add('GET', '/userprofile/update', function () {
    (new UsuarioController())->update();
});

Router::add('POST', '/userprofile/update', function () {
    (new UsuarioController())->update();
});


Router::add('GET', '/contact', function () {
    (new HomeController())->contacto();
});

Router::add('GET', '/aboutus', function () {
    (new HomeController())->aboutus();
});

//CREADOR

Router::add('GET', 'creator/request', function () {
    (new UsuarioController())->solicitud();
});

Router::add('POST', 'creator/request', function () {
    (new UsuarioController())->solicitud();
});


//ADMINISTRADOR

Router::add('GET', 'admin/requests', function () {
    (new UsuarioController())->solicitud();
});

Router::add('POST', 'admin/requests', function () {
    (new UsuarioController())->solicitud();
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

Router::add('GET', 'admin/deleteuser', function () {
    (new UsuarioController())->borrarUsuario();
});

Router::add('GET', 'admin/edituser', function () {
    (new UsuarioController())->registro();
});

Router::add('POST', 'admin/edituser', function () {
    (new UsuarioController())->registro();
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