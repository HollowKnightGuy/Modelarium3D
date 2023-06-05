
<?php 
$estilos = 'contact'; ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilos ?>.css">
<?php
require_once '../views/layout/contactheader.php';

?>

    
    <div class="contact-img-container">
        <img class="bg-contact" src="<?= $_ENV['BASE_URL_PUBLIC']?>img/contact/DALL·E 2023-05-19 12.31.29 - retro arade sunset.png" alt="">
    </div>

    <div class="contact-form-container">
        <div class="contact-form-card">

            <form class="contact-form" action="#">
                <div class="section section1">
                    <div class="contact-name">
                        <img src="<?= $_ENV['BASE_URL_PUBLIC']?>img/contact/input.png" alt="">
                        <input type="text" placeholder="NAME">
                    </div>
                    <div class="contact-email">
                        <img src="<?= $_ENV['BASE_URL_PUBLIC']?>img/contact/input.png" alt="">
                        <input type="email" placeholder="EMAIL">
                    </div>
                </div>
                <div class="section contact-description">
                    <img src="<?= $_ENV['BASE_URL_PUBLIC']?>img/contact/big-input.png" alt="">
                    <textarea class="contact-description" name="description" id="desc" cols="30" rows="10" placeholder="DESCRIPTION"></textarea>
                </div>
                <div class="contact-submit">
                    <input class="contactbtn" type="submit" value="SEND">
                </div>

            </form>

        </div>
    </div>
</body>
</html>