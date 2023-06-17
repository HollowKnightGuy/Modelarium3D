<?php
$estilos = 'about'; ?>
<link rel="stylesheet" href=" <?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilos ?>.css">
<?php
require_once '../views/layout/header.php';

use Controllers\ModeloController;
use Controllers\PeticionController;

$modeloController = new ModeloController();
$peticionController = new PeticionController();
?>
<title>Modelarium3D - Requests</title>

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
        <li class="section" onclick="changeReqstate('block', 'none', 'none')">Models</li>
        <li class="section" onclick="changeReqstate('none', 'block', 'none')">Creators</li>
        <li class="section" onclick="changeReqstate('none', 'none', 'block')">Comments</li>
    </ul>

    <div class="section-request">
        <section>
            <table id="requests">
                <?php
                $pendientes = $modeloController->obtenerModelosPendientes();

                if (!empty($pendientes)) :
                ?>
                    <tr>
                        <?php foreach ($pendientes[0] as $columna => $valor) : ?>
                            <th><?= $columna ?></th>
                        <?php endforeach; ?>
                    </tr>
                    <?php foreach ($pendientes as $pendiente) : ?>
                        <tr class="transition request">
                            <?php foreach ($pendiente as $valor) :
                                if ($valor == $pendiente->foto_modelo) : ?>
                                    <td><img src="<?= $_ENV['BASE_URL_PUBLIC'] ?>img/models/<?= $valor ?>" alt="<?= $valor ?>" width="80px" /></td>
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
                <?php else : ?>
                    <tr>
                        <td colspan="5">No se encontraron resultados.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </section>

        <div class="user-opt">
            <a class="defaultbtn" id="rechazarbtn" href="<?= $_ENV['BASE_URL'] ?>admin/denyrequest/MO/id=">Rechazar Petición</a>
            <a class="defaultbtn" id="aceptarbtn" href="<?= $_ENV['BASE_URL'] ?>admin/acceptrequest/MO/id=">Aceptar Petición</a>
        </div>
    </div>

    <div class="section-request" style="display: none;">
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
                <?php else : ?>
                    <tr>
                        <td colspan="5">No se encontraron resultados.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </section>
    </div>
    <div class="section-request" style="display: none;">
    <section>
            <table>
                <?php
                $pendientes = $peticionController->obtenerComentariosPendientes();
                if (!empty($pendientes)) :
                ?>
                    <tr>
                        <?php foreach ($pendientes[0] as $columna => $valor) :
                            if ($columna != 'tipo') : ?>
                                <th><?= $columna ?></th>
                            <?php endif;
                        endforeach; ?>
                    </tr>

                    <?php foreach ($pendientes as $pendiente) :  ?>
                        
                        <tr class="transition" onclick="redirectToPage('<?= $pendiente -> id_comentario ?>', 'requests/comments/')">
                            <?php foreach ($pendiente as $columna => $valor) :
                                if ($columna != 'tipo') :
                                    if ($valor == $pendiente->id) : ?>
                                        <td id="<?= $valor ?>"><?= $valor ?></td>
                                    <?php else : ?>
                                        <td><?= $valor ?></td>
                                    <?php endif;
                                endif;
                            endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">No se encontraron resultados.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </section>
    </div>
</div>
</div>
<script>

    const requests = document.getElementsByClassName("requests");
    const rechazarbtn = document.getElementById("rechazarbtn");
    const aceptarbtn = document.getElementById("aceptarbtn");
    const adminLinks = document.getElementsByClassName("section");
    const sectionReq = document.getElementsByClassName("section-request")
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


    let lastclickedp



    function changeRLinkstates(link, newlink) {
        if (typeof link != "undefined") {
            link.classList.toggle("plink-clicked")
        }
        lastclickedp = adminLinks[newlink];
        adminLinks[newlink].classList.toggle("plink-clicked");
    }

    function changeReqstate(s1, s2, s3) {
        sectionReq[0].style.display = s1;
        sectionReq[1].style.display = s2;
        sectionReq[2].style.display = s3;


        if (s1 !== "none") {
            changeRLinkstates(lastclickedp, 0);
        } else if (s2 !== "none") {
            changeRLinkstates(lastclickedp, 1);
        } else if (s3 !== "none") {
            changeRLinkstates(lastclickedp, 2);
        }
    }
</script>