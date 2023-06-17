<?php
$estilos = 'contact'; ?>
<link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilos ?>.css">
<?php
require_once '../views/layout/contactheader.php';
$error_img = '<img class="retro_error" src=' . $_ENV['BASE_URL_PUBLIC'] . 'img/icons/exclamation.svg alt=error>';
$tick_img = '<img class="retro_error" src=' . $_ENV['BASE_URL_PUBLIC'] . 'img/icons/tick.svg alt=error>';
?>
<title>Modelarium3D - Contact</title>


<div class="contact-img-container">
    <img class="bg-contact" src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/contact/DALL·E 2023-05-19 12.31.29 - retro arade sunset.png" alt="">
</div>

<div class="contact-form-container">
    <div class="contact-form-card">

        <form class="contact-form" action="contact" method="POST">
            <div class="section section1">
                <div class="contact-name">
                    <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/contact/input.png" alt="">
                    <input require type="text" value="<?= $datos_guardados['name'] ?? "" ?>" name="data[name]" placeholder="NAME">
                </div>
                <div class="contact-email">
                    <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/contact/input.png" alt="">
                    <input require type="email" value="<?= $datos_guardados['email'] ?? "" ?>" name="data[email]" placeholder="EMAIL">
                </div>
            </div>
            <?php if (isset($message) && $message['nombre_email'] != "") : ?>

                <div class="retro_error_container">
                    <?= $error_img ?>
                    <span style='font-size:var(--fs-200); color:#fd2121;'><?= $message['nombre_email'] ?></span>
                </div>
            <?php endif; ?>
            <div class="section contact-description">
                <img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/contact/big-input.png" alt="">
                <textarea require class="contact-description" name="data[desc]" id="desc" cols="30" rows="10" placeholder="DESCRIPTION"><?= $datos_guardados['desc'] ?? "" ?></textarea>
            </div>
            <?php if (isset($message) && $message['desc'] != "") : ?>
                <div class="retro_error_container">
                    <?= $error_img ?>
                    <span style='font-size:var(--fs-200); color:#fd2121;'><?= $message['desc'] ?></span>
                </div>
            <?php endif; ?>
            <div class="contact-submit">
                <input class="contactbtn" type="submit" value="SEND">
            </div>
            <?php if (isset($enviado) && $enviado === true) : ?>
                <div class="successful">
                    <?= $tick_img ?>
                    <span style="font-size:var(--fs-200);color: #31a31a;">Sended successgfully</span>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>
</body>

</html>