<?php
include_once 'components/header.php';
?>
<body>

<?php
include_once 'components/navbar.php';
?>

<?php
include_once 'backend/database.php';
$result = mysqli_query($conn,"SELECT * FROM student WHERE identifier='" . $_GET['ID'] . "'");
$row= mysqli_fetch_array($result);
?>

<div class="container jumbotron">
    <h2>Actualización de estudiantes</h2>
    <form>
        <div>
            <p class="lead">Carnet:</p>
            <input readonly type="text" class="lead" name="id" id="id" value="<?php echo $row['identifier']; ?>">
            <span class="lead" id="idMessage"></span>
        </div>
        <div>
            <p class="lead">Nombres: </p>
            <input type="text" class="lead" name="firstName" id="firstName" value="<?php echo $row['full_name']; ?>">
        </div>
        <div>
            <p class="lead">Apellidos:</p>
            <input type="text" class="lead" name="lastName" id="lastName" value="<?php echo $row['last_name']; ?>">
        </div>
        <div class="lead">
            <input type="hidden" value="2" name="type" id="type">
            <input type="button" class="btn btn-success" id="sendStudentData"  data-toggle="modal" data-target="#messageModal" onclick="sendData()"  value="Actualizar">
        </div>
    </form>
</div>

<?php
include_once 'components/footer.php';
?>