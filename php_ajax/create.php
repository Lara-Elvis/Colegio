<?php
include_once 'components/header.php';


include_once 'components/navbar.php';
?>

<div class="container jumbotron">
    <h2>Creación de estudiantes</h2>
    <!--<form method="post" action="process.php">-->
    <form>
        <div>
            <p class="lead">Carnet:</p>
            <input type="text" class="lead" name="id" id="id" onkeyup="searchId(this.value)">
            <span class="lead" id="idMessage"></span>
        </div>
        <div>
            <p class="lead">Nombres: </p>
            <input type="text" class="lead" name="firstName" id="firstName">
        </div>
        <div>
            <p class="lead">Apellidos:</p>
            <input type="text" class="lead" name="lastName" id="lastName">
        </div>

        <div>
            <p class="lead">Fecha de Nacimiento (DD/MM/YYYY):</p>
            <input type="text" class="lead" name="birthDate" id="birthDate" placeholder="DD/MM/YYYY">
        </div>

        <div class="lead">
            <input type="hidden" value="1" name="type" id="type">
            <input type="button" class="btn btn-primary" id="sendStudentData"  data-toggle="modal" data-target="#messageModal" onclick="sendData()" value="Guardar">
        </div>
    </form>
</div>

<!-- Creación de maestros -->

<div class="container jumbotron">
    <h2>Creación de maestros</h2>
    <!--<form method="post" action="process.php">-->
    <form>
        <div>
            <p class="lead">Carnet:</p>
            <input type="text" class="lead" name="id" id="id" onkeyup="searchId(this.value)">
            <span class="lead" id="idMessage"></span>
        </div>
        <div>
            <p class="lead">Nombres: </p>
            <input type="text" class="lead" name="firstName" id="firstName">
        </div>
        <div>
            <p class="lead">Apellidos:</p>
            <input type="text" class="lead" name="lastName" id="lastName">
        </div>

        <div>
            <p class="lead">Fecha de Nacimiento (DD/MM/YYYY):</p>
            <input type="text" class="lead" name="birthDate" id="birthDate" placeholder="DD/MM/YYYY">
        </div>

        <div class="lead">
            <input type="hidden" value="1" name="type" id="type">
            <input type="button" class="btn btn-primary" id="sendStudentData"  data-toggle="modal" data-target="#messageModal" onclick="sendDataTeacher()" value="Guardar">
        </div>
    </form>
</div>

<?php
include_once 'components/footer.php';
?>