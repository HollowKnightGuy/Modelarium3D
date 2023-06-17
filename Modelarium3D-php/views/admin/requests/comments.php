
<?php
$estilos = 'about'; ?>
<link rel="stylesheet" href=" <?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilos ?>.css">
<?php
require_once '../views/layout/header.php';
?>
<title>Modelarium3D - Requests</title>

<style>
    
    th,
    td {
        border: 1px solid grey;
        text-align: center;
        max-width: 200px;
        word-wrap: break-word;
        padding: .5rem;
        font-size: var(--fs-200);
    }

    th {
        color: var(--primary-color)
    }

    table {
        width: 95%;
        border-collapse: collapse;
    }

    .user-opt {
        bottom: -50px;
        position: fixed;
        margin-bottom: 3rem;
        width: 100%;
        height: 100px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        background-color: var(--bg-color);
    }

    .user-opt a {
        font-size: var(--fs-300);
        text-align: center;
    }

    .title{
        display: flex;
        width: 100%;
        align-items: center;
        justify-content: center;
        padding: 50 10 10 10;
    }

    .model, .user, .comment{
        display: flex;
        flex-direction: column;
        width: 100%;
        justify-content: center;
        align-items: center;
    }
</style>

<div class="user">
    <h1 class="title">User Who Commented</h1>
    <table>
        <?php foreach ($usuario as $key => $value) : ?>
            <tr>
                <th><?= $key ?></th>
                <td><?= $value ?></td>
            </tr>
        <?php endforeach; ?>

    </table>
</div>

<div class="model">
    <h1 class="title">Model Commented</h1>
    <?php $modelo ?>
    <table>
        <?php foreach ($modelo as $key => $value) : ?>
            <?php if ($key === "foto_modelo") : ?>
                <th><?= $key ?></th>
                <td><img src="<?= $_ENV['BASE_URL_PUBLIC']?>img/models/<?=$value?>" alt="Foto Modelo" width="200px"></td>
            <?php else : ?>

                <tr>
                    <th><?= $key ?></th>
                    <td><?= $value ?></td>
                </tr>
                <?php endif; ?>
        <?php endforeach; ?>

    </table>
</div>


<div class="comment">
    <h1 class="title">Comment</h1>
    
    <?php $comentario ?>
    <table>
        <?php foreach ($comentario as $key => $value) : ?>
            <tr>
                <th><?= $key ?></th>
                <td><?= $value ?></td>
            </tr>
        <?php endforeach; ?>

    </table>
</div>

    <div class="user-opt">
        <a class="defaultbtn" id="rechazarbtn" href="<?= $_ENV['BASE_URL'] ?>admin/denyrequest/CO/id=<?= $peticion -> id?>">Rechazar Petición</a>
        <a class="defaultbtn" id="aceptarbtn" href="<?= $_ENV['BASE_URL'] ?>admin/acceptrequest/CO/id=<?=$peticion -> id?>">Aceptar Petición</a>
    </div>