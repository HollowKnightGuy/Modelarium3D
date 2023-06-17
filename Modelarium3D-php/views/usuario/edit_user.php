<?php
$estilos = ['profile', 'form', 'profilesettings'];
foreach ($estilos as $estilo) :  ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilo ?>.css">
<?php
endforeach;
require_once '../views/layout/header.php';

use Controllers\UsuarioController;

$usuarioC = new UsuarioController;
isset($id) ? $_SESSION['idUserToEdit'] = $id : "";
$userdata = $usuarioC->obtenerUsuarioPorId($_SESSION['idUserToEdit']);
$error_img = '<img src=' . $_ENV['BASE_URL_PUBLIC'] . 'img/icons/error.svg alt=error>';
?>

<title>Modelarium3D - Edit Profile</title>


<main class="psmain">
    <script src="<?= $_ENV['BASE_URL_PUBLIC'] ?>js/psmain.js"></script>
    <section class="profile-settings-content">
        <article class="profsetsection" id="psprofile">
            <h1>Edit User</h1>
            <form class="container psprofile-form" method="POST" action="<?= $_ENV['BASE_URL'] ?>userprofile/update" enctype="multipart/form-data">
                <div class="inputcontainer psform-input-cont">
                    <label for="name">Name</label>
                    <input id="name" name="data[name]" type="text" value="<?= $userdata->nombre; ?>" required>
                </div>
                <span class="red-error">
                    <?= $message['nombre'] === "" ? "" : $error_img . $message['nombre']; ?>
                </span>
                <div class="inputcontainer psform-input-cont">
                    <label for="bio">Bio</label>
                    <textarea id="bio" name="data[bio]" type="text" rows="8"><?= isset($datos['bio']) ? $datos['bio'] : $userdata->descripcion ?></textarea>
                </div>
                <span class="red-error">
                    <?= $message['descripcion'] === "" ? "" : $error_img . $message['descripcion']; ?>
                </span>
                <div class="banner-img-container">
                    <div class="ps-prof-img">
                        <label for="profs-img">Profile Image</label>
                        <input type="file" name="profile_img" id="input-ps-img" hidden>
                        <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/user/profilephoto/<?= $userdata->foto_perfil; ?>" width="100px" alt="profile.jpg" class="ps-img" required>
                        <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/default/pencil.png" alt="pencil" width="100px" class="ps-img pencil-img none transition" id="pencil1">
                    </div>
                    <div class="ps-prof-banner">
                        <label for="profs-banner">Banner Image</label>
                        <input type="file" name="profile_banner" id="input-ps-banner" hidden>

                        <?php if ($userdata->banner == NULL) {
                            $route = $_ENV['BASE_URL_PUBLIC'] . "img/default/banner.jpg";
                        } else {
                            $route = $_ENV['BASE_URL_PUBLIC'] . "img/user/profilebanner/" . $userdata->banner;
                        } ?>
                        <img src="<?= $route ?>" width="150px" alt="banner.jpg" class="ps-img">
                        <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/default/pencil.png" alt="pencil" width="100px" class="ps-img pencil-img none transition" id="pencil2">
                    </div>
                </div>
                <span class="red-error">
                    <?= $message['imagen'] === "" ? "" : $error_img . $message['imagen']; ?>
                </span>
                <span class="red-error">
                    <?= $message['imagenbanner'] === "" ? "" : $error_img . $message['imagenbanner']; ?>
                </span>
                <div class="inputcontainer psform-input-cont">
                    <label for="email">Correo Electrónico</label>
                    <input id="email" type="text" value="<?php echo ($userdata->email) ?>" readonly>
                </div>
                <input type="submit" class=" submit transition boxshadow" id="psform-edit" value="SAVE CHANGES">
            </form>
        </article>
    </section>
</main>