<?php
$estilos = 'about'; ?>
<link rel="stylesheet" href=" <?= $_ENV['BASE_URL'] ?>css/<?= $estilos ?>.css">
<?php
require_once '../views/layout/header.php';
?>
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
}

tr:hover{
    background-color: var(--secondary-color);
    background-color: #dca5fa;
    cursor: pointer;
}
.tdselected{
    background-color: var(--secondary-color);
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
            <th>Nº Modelos</th>
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
                <td><?= $usuario['foto_perfil'] === "" ? "-" : $usuario['foto_perfil'] ?></td>
                <td><?= $usuario['banner'] === "" ? "-" : $usuario['banner'] ?></td>
                <td><?= $usuario['num_modelos'] === "" ? "-" : $usuario['num_modelos'] ?></td>
                <td><?= $usuario['descuento'] === "" ? "-" : $usuario['descuento'] ?></td>
                <td><?= $usuario['fecha_creacion'] === "" ? "-" : $usuario['fecha_creacion'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="user-opt">
        <a class="defaultbtn" href="<?= $_ENV['BASE_URL']?>admin/createuser">Crear Usuario</a>
        <a class="defaultbtn">Editar Usuario Seleccionado</a>
        <a class="defaultbtn">Borrar Usuario Seleccionado</a>
    </div>
</div>
<script>
    const users = document.getElementsByClassName("user");
    let lastclicked; 
    $(".user").on("click",function(e){
        let iduser = e.target.parentElement.children[0].attributes['id'].nodeValue;
        if(lastclicked != undefined){
            lastclicked.classList.toggle("tdselected");
        }
        lastclicked = e.target.parentElement;
        lastclicked.classList.toggle("tdselected");
    });
</script>