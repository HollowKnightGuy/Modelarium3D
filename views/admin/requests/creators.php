<?php
$estilos = 'about'; ?>
<link rel="stylesheet" href=" <?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilos ?>.css">
<?php
require_once '../views/layout/header.php';

?>

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
</style>

<?php 
$modelo = $modelo[0];
$id = $modelo -> id;

if (!empty($modelo)) {
    echo '<table>';
    echo '<tr>';
    foreach ($modelo as $key => $value) {
        echo '<th>' . $key . '</th>';
    }
    echo '</tr>';

    echo '<tr>';
    foreach ($modelo as $key => $value) {
        echo '<td>';
        if ($key === "foto_modelo") {
            echo '<img src="' .$_ENV['BASE_URL_PUBLIC']. 'img/models/' . $value . '" alt="Foto Modelo" width="200px">';
        } else {
            echo $value;
        }
        echo '</td>';
    }
    echo '</tr>';

    echo '</table>';
} else {
    echo 'No se encontraron datos.';
}

?>

<!-- TODO: QUE funsione -->
<?php var_dump($id)?>

    <div class="user-opt">
        <a class="defaultbtn" id="rechazarbtn" href="<?= $_ENV['BASE_URL'] ?>admin/denyrequest/BC/id=">Rechazar Petición</a>
        <a class="defaultbtn" id="aceptarbtn" href="<?= $_ENV['BASE_URL'] ?>admin/acceptrequest/BC/id=".$id>Aceptar Petición</a>
    </div>