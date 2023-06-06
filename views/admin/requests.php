<?php
$estilos = 'about'; ?>
<link rel="stylesheet" href=" <?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilos ?>.css">
<?php
require_once '../views/layout/header.php';

use Controllers\ModeloController;

$modeloController = new ModeloController();
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

    tr:first-child:hover {
        background-color: var(--bg-color);
        cursor: auto;
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
        <table id="requests" >
            <?php
            $pendientes = $modeloController->obtenerPendientes();

            if (!empty($pendientes)) : ?>
                <tr>
                    <?php foreach ($pendientes[0] as $columna => $valor) : ?>
                        <th><?= $columna ?></th>
                    <?php endforeach; ?>

                    <?php foreach ($pendientes as $pendiente) : ?>
                <tr class="transition request">
                    <?php foreach ($pendiente as $valor) :
                            if ($valor == $pendiente->foto_modelo) : ?>
                            <td><img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/modelRequest/photos/<?= $valor ?>" alt="<?= $valor ?>" width=80px /></td>
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
        <a class="defaultbtn" href="<?= $_ENV['BASE_URL'] ?>admin/denyrequest/id=">Rechazar Petición</a>
        <a class="defaultbtn" id="editarbtn" href="<?= $_ENV['BASE_URL'] ?>admin/acceptrequest/id=">Aceptar Petición</a>
    </div>
</div>
<script>
    const requests = document.getElementsByClassName("requests");
    const borrarbtn = document.getElementById("borrarbtn");
    const editarbtn = document.getElementById("editarbtn");
    let lastclicked;
    $(".request").on("click", function(e) {
        let iduser = e.target.parentElement.children[0].attributes['id'].nodeValue;
        console.log(iduser);
        if (lastclicked != undefined) {
            setLink(iduser, borrarbtn);
            setLink(iduser, editarbtn);
            lastclicked.classList.toggle("tdselected");
        } else {
            borrarbtn.href += iduser;
            editarbtn.href += iduser;
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
</script>