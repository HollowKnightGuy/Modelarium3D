<?php
$estilos = 'form'; ?>
<link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilos ?>.css">
<?php
require_once '../views/layout/header.php';
$error_img = '<img src='.$_ENV['BASE_URL_PUBLIC'].'img/icons/error.svg alt=error>';

?>
<main>
    <div class="container">
        <h1 class="title">Login</h1>
        <form action="<?php $_ENV['BASE_URL'] ?>login" method="POST" class="form">
            <div class="input-container">
                <input type="email" name="data[email]" value="<?= $datos_guardados['email'] ?? "" ?>" id="email" placeholder="email@example.com" required> <span class="required">*</span>
            </div>
            <span class="red-error">
                <?= $message['email'] === "" ? "" : $error_img.$message['email']; ?>
            </span>

            <div class="input-container">
                <input type="password" name="data[pass]" id="pass" placeholder="··············" required> <span class="required">*</span>
            </div>
            <span class="red-error">
                <?= $message['password'] === "" ? "" : $error_img.$message['password']; ?>
            </span>
            <span><?= $_SESSION['error_login'] ?? "" ?></span>
            <input class="submit transition" type="submit" value="LOGIN">
            <span>Are you not registered? <a class="linkpurple" href="<?= $_ENV['BASE_URL'] ?>register">Click here</a></span>
        </form>
    </div>
</main>