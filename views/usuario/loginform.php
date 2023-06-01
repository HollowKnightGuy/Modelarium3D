<?php 
$estilos = 'form'; ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>css/<?= $estilos ?>.css">
<?php
require_once '../views/layout/header.php';
?>
    <main>
        <div class="container">
            <h1 class="title">Login</h1>
            <form action="<?php $_ENV['BASE_URL']?>login" method="POST" class="form">
                <div class="input-container">
                    <input type="email" name="data[email]" id="email" placeholder="email@example.com" required> <span class="required">*</span>
                </div>
                <div class="input-container">
                    <input type="password" name="data[pass]" id="pass" placeholder="··············" required> <span class="required">*</span>
                </div>
                <span><?= $_SESSION['error_login'] ?></span>
                <input class="submit transition" type="submit" value="LOGIN">
                <span>Are you not registered? <a class="linkpurple" href="<?=$_ENV['BASE_URL']?>register">Click here</a></span>                    
            </form>
        </div>
    </main>
