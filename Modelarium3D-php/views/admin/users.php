<?php
$estilos = 'about'; ?>
<link rel="stylesheet" href=" <?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilos ?>.css">
<?php
require_once '../views/layout/header.php';
?>
    <title>Modelarium3D - Users</title>

<style>
    .users{
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        flex-direction: column-reverse;
    }
    th{
        color: var(--primary-color);
    }
    table {
        width: 95%;
  border-collapse: collapse;
}
tr, th, td{
    text-align: center;
    border: 1px solid grey;
    padding: .3rem;
    font-size: var(--fs-200);
}

tr:hover{
    background-color: var(--secondary-color);
    background-color: #dca5fa;
    cursor: pointer;
}
.tdselected{
    background-color: var(--secondary-color);
    color: white;
}
.tdselected:hover{
    background-color: var(--secondary-color);
}
tr:first-child:hover{
    background-color: var(--bg-color);
    cursor: auto;
}
.user-opt{
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
.user-opt a{
    font-size: var(--fs-300);
    text-align: center;
}

</style>
<div class="users">
    <table id="table">
        <tr>
            <th>Id</th>
            <th>Rol</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Descripción</th>
            <th>Foto Perfil</th>
            <th>Banner</th>
            <th>Descuento</th>
            <th>Fecha Creacion</th>
        </tr>
        <?php foreach ($usuarios as $usuario) : ?>
            <tr class="transition user">
                <td id="<?= $usuario['id'] === "" ? "-" : $usuario['id'] ?>"><?= $usuario['id'] === "" ? "-" : $usuario['id'] ?></td>
                <td><?= $usuario['rol'] === "" ? "-" : $usuario['rol'] ?></td>
                <td><?= $usuario['nombre'] === "" ? "-" : $usuario['nombre'] ?></td>
                <td><?= $usuario['email'] === "" ? "-" : $usuario['email'] ?></td>
                <td><?= $usuario['descripcion'] === "" ? "-" : $usuario['descripcion'] ?></td>
                <td><img width="40px" src="<?= $usuario['foto_perfil'] === "" ? $_ENV['BASE_URL_PUBLIC']."img/default/profile.jpg" : $_ENV['BASE_URL_PUBLIC']."img/user/profilephoto/".$usuario['foto_perfil'] ?>" ></td>
                <td><img width="100px" src="<?= $usuario['banner'] === null ? $_ENV['BASE_URL_PUBLIC']."img/default/banner.jpg" : $_ENV['BASE_URL_PUBLIC']."img/user/profilebanner/".$usuario['banner'] ?>" ></td>
                <td><?= $usuario['ganancias'] === "" || $usuario['ganancias'] === null ? "-" : $usuario['ganancias'] ?></td>
                <td><?= $usuario['fecha_creacion'] === "" ? "-" : $usuario['fecha_creacion'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="user-opt">
        <a class="defaultbtn" href="<?= $_ENV['BASE_URL']?>admin/createuser">Crear Usuario</a>
        <a class="defaultbtn" id="editarbtn" href="<?= $_ENV['BASE_URL']?>admin/updateuser/id=">Editar Usuario Seleccionado</a>
        <a class="defaultbtn" id="borrarbtn" href="<?= $_ENV['BASE_URL']?>admin/deleteuser/id=">Borrar Usuario Seleccionado</a>
    </div>
</div>
<script>
    const users = document.getElementsByClassName("user");
    const borrarbtn = document.getElementById("borrarbtn");
    const editarbtn = document.getElementById("editarbtn");
    let lastclicked; 
    $(".user").on("click",function(e){
        let iduser = e.target.parentElement.children[0].attributes['id'].nodeValue;
        if(lastclicked != undefined){
            setLink(iduser, borrarbtn);
            setLink(iduser, editarbtn);
            lastclicked.classList.toggle("tdselected");
        }else{
            borrarbtn.href += iduser;
            editarbtn.href += iduser;
        }
        lastclicked = e.target.parentElement;
        lastclicked.classList.toggle("tdselected");
    });

    function setLink(iduser, node){
        let link = node.href.split("=");
        link[1] = iduser;
        link = link.join("=");
        node.href = link;
    }
</script>