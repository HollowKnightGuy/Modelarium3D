<?php
$estilos = 'about'; ?>
<link rel="stylesheet" href=" <?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilos ?>.css">
<?php
require_once '../views/layout/header.php';

use Controllers\ModeloController;
use COntrollers\PeticionController;

$modeloController = new ModeloController();
$peticionController = new PeticionController();
?>

<style>
    .container {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        gap: 2rem;
    }

    .title {
        display: flex;
        width: 100%;
        flex-direction: column;
        align-items: center;
    }

    .links {
        display: flex;
        width: 100%;
        flex-direction: row;
        align-items: center;
        justify-content: space-around;
    }

    .section {
        padding: 10px;
        border-radius: 8px;
        transition: all 300ms;
    }

    .section:hover {
        background-color: #70707040;
        cursor: pointer;
    }

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

    tr:hover {
        background-color: var(--secondary-color);
        background-color: #dca5fa;
        cursor: pointer;
    }

    .tdselected {
        background-color: var(--secondary-color);
        color: white;
    }

    .tdselected:hover {
        background-color: var(--secondary-color);
    }

    tr:first-child:hover {
        background-color: var(--bg-color);
        cursor: auto;
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
        left: 0;
    }

    .user-opt a {
        font-size: var(--fs-300);
        text-align: center;
    }
</style>

<div class="container">

    <h1 class="title">Requests</h1>

    <ul class="links">
        <li class="section">Models</li>
        <li class="section">Comments</li>
        <li class="section">Creators</li>
    </ul>

    <section>
        <table id="requests">
            <?php
            $pendientes = $modeloController->obtenerModelosPendientes();

            if (!empty($pendientes)) : ?>
                <tr>
                    <?php foreach ($pendientes[0] as $columna => $valor) : ?>
                        <th><?= $columna ?></th>
                    <?php endforeach; ?>

                    <?php foreach ($pendientes as $pendiente) : ?>
                <tr class="transition request">
                    <?php foreach ($pendiente as $valor) :
                            if ($valor == $pendiente->foto_modelo) : ?>
                            <td><img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/models/<?= $valor ?>" alt="<?= $valor ?>" width=80px /></td>
                        <?php else : ?>
                            <?php if ($valor == $pendiente->id) : ?>
                                <td id="<?= $valor ?>"><?= $valor ?></td>
                            <?php else : ?>
                                <td><?= $valor ?></td>
                            <?php endif; ?>
                        <?php endif; ?>

                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>

            </tr>

        </table>
    <?php else : ?>
        <p>No se encontraron resultados.</p>
    <?php endif; ?>
</section>

<div class="user-opt">
    <a class="defaultbtn" id="rechazarbtn" href="<?= $_ENV['BASE_URL'] ?>admin/denyrequest/MO/id=">Rechazar Petición</a>
    <a class="defaultbtn" id="aceptarbtn" href="<?= $_ENV['BASE_URL'] ?>admin/acceptrequest/MO/id=">Aceptar Petición</a>
</div>

    <section>
    <table>
    <?php
    $pendientes = $peticionController->obtenerCreatorsPendientes();

    if (!empty($pendientes)) :
        ?>
        <tr>
            <?php foreach ($pendientes[0] as $columna => $valor) :
                if ($columna != 'id_comentario' && $columna != 'tipo') : ?>
                    <th><?= $columna ?></th>
                <?php endif;
            endforeach; ?>
        </tr>

        <?php foreach ($pendientes as $pendiente) : ?>
            <tr class="transition" onclick="redirectToPage('<?= $pendiente->id ?>', 'requests/creators/')">
                <?php foreach ($pendiente as $columna => $valor) :
                    if ($columna != 'id_comentario' && $columna != 'tipo') :
                        if ($valor == $pendiente->id) : ?>
                            <td id="<?= $valor ?>"><?= $valor ?></td>
                        <?php else : ?>
                            <td><?= $valor ?></td>
                        <?php endif;
                    endif;
                endforeach; ?>
            </tr>
        <?php endforeach; ?>

</table>

    <?php else : ?>
        <p>No se encontraron resultados.</p>
    <?php endif; ?>
    </section>
</div>
<script>
    const requests = document.getElementsByClassName("requests");
    const rechazarbtn = document.getElementById("rechazarbtn");
    const aceptarbtn = document.getElementById("aceptarbtn");
    let lastclicked;
    $(".request").on("click", function(e) {
        let iduser = e.target.parentElement.children[0].attributes['id'].nodeValue;
        if (lastclicked != undefined) {
            setLink(iduser, aceptarbtn);
            setLink(iduser, rechazarbtn);
            lastclicked.classList.toggle("tdselected");
        } else {
            aceptarbtn.href += iduser;
            rechazarbtn.href += iduser;
        }
        lastclicked = e.target.parentElement;
        lastclicked.classList.toggle("tdselected");
    });

    function setLink(iduser, node) {
        let link = node.href.split("=");
        link[1] = iduser;
        link = link.join("=");
        node.href = link;
    }

    function redirectToPage(id, enlace) {
        window.location.href = enlace + 'id=' + id;
    }
</script>