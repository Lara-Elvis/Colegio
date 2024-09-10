<?php
include_once 'components/header.php';
?>
<body>

<?php
include_once 'components/navbar.php';
?>

<?php
include_once 'backend/database.php';
$result = mysqli_query($conn, "SELECT * FROM student");
?>


<div class="container jumbotron">
    <h2>Listado de estudiantes</h2>
    <?php
    if (mysqli_num_rows($result) > 0) {
        ?>
        <table>
            <tr>
                <td>Carnet</td>
                <td>Nombre</td>
                <td>Apellido</td>
                <td>Nota</td>
                <td>Acciones</td>
            </tr>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                // Obtener la nota del alumno
                $student_id = $row["identifier"];
                $grade_result = mysqli_query($conn, "SELECT total_grade FROM grade
                                                    INNER JOIN enrollment ON grade.enrollment_id = enrollment.enrollment_id
                                                    WHERE enrollment.student_id = $student_id");

                $grade_row = mysqli_fetch_array($grade_result);
                $total_grade = $grade_row ? $grade_row["total_grade"] : "Sin nota";

                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["identifier"]); ?></td>
                    <td><?php echo htmlspecialchars($row["full_name"]); ?></td>
                    <td><?php echo htmlspecialchars($row["last_name"]); ?></td>
                    <td><?php echo htmlspecialchars($total_grade); ?></td>
                    <td>
                        <a class="btn btn-success" href="update.php?ID=<?php echo htmlspecialchars($row["identifier"]); ?>">Update</a>
                        <a class="btn btn-danger" href="delete.php?ID=<?php echo htmlspecialchars($row["identifier"]); ?>">Delete</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    } else {
        echo "No existen estudiantes";
    }
    ?>
</div>



<?php
include_once 'backend/database.php';
$result = mysqli_query($conn, "SELECT * FROM teacher");
?>

<div class="container jumbotron">
    <h2>Listado de maestros</h2>
    <?php
    if (mysqli_num_rows($result) > 0) {
        ?>
        <table>
            <tr>
                <td>Carnet</td>
                <td>Nombre</td>
                <td>Apellido</td>
                <td>Fecha de Nacimiento</td>
                <td>Edad</td>
                <td>Acciones</td>
            </tr>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                // Obtener la fecha de nacimiento y calcular la edad
                $birth_date = $row["birth_date"];
                $birth_date_obj = new DateTime($birth_date);
                $today = new DateTime('today');
                $age = $today->diff($birth_date_obj)->y;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["teacher_id"]); ?></td>
                    <td><?php echo htmlspecialchars($row["full_name"]); ?></td>
                    <td><?php echo htmlspecialchars($row["last_name"]); ?></td>
                    <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($birth_date))); ?></td>
                    <td><?php echo htmlspecialchars($age); ?></td>
                    <td>
                        <a class="btn btn-success" href="update.php?ID=<?php echo htmlspecialchars($row["teacher_id"]); ?>">Update</a>
                        <a class="btn btn-danger" href="delete.php?ID=<?php echo htmlspecialchars($row["teacher_id"]); ?>">Delete</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    } else {
        echo "No existen maestros";
    }
    ?>
</div>

<div class="container jumbotron">
    <h2>Listado de Maestros y Cursos Asignados</h2>
    <?php
    // Consulta para obtener los maestros, sus cursos, y los estudiantes inscritos
    $query = "
        SELECT 
            teacher.teacher_id, 
            teacher.full_name AS teacher_first_name, 
            teacher.last_name AS teacher_last_name,
            teacher.birth_date,
            course.course_name,
            course.course_id,
            GROUP_CONCAT(CONCAT(student.full_name, ' ', student.last_name) SEPARATOR ', ') AS enrolled_students
        FROM 
            teacher
        JOIN 
            course ON teacher.teacher_id = course.teacher_id
        LEFT JOIN 
            enrollment ON course.course_id = enrollment.course_id
        LEFT JOIN 
            student ON enrollment.student_id = student.identifier
        GROUP BY 
            teacher.teacher_id, course.course_id
        ORDER BY 
            teacher.teacher_id, course.course_id;
    ";
    
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        ?>
        <table>
            <tr>
                <td>Carnet Maestro</td>
                <td>Nombre del Maestro</td>
                <td>Apellido del Maestro</td>
                <td>Fecha de Nacimiento</td>
                <td>Edad</td>
                <td>Curso Asignado</td>
                <td>Estudiantes Inscritos</td>
                <td>Acciones</td>
            </tr>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                // Obtener la fecha de nacimiento y calcular la edad
                $birth_date = $row["birth_date"];
                $birth_date_obj = new DateTime($birth_date);
                $today = new DateTime('today');
                $age = $today->diff($birth_date_obj)->y;
                
                // Verificar si hay estudiantes inscritos
                $enrolled_students = $row["enrolled_students"] ?: "Ningún estudiante inscrito";
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["teacher_id"]); ?></td>
                    <td><?php echo htmlspecialchars($row["teacher_first_name"]); ?></td>
                    <td><?php echo htmlspecialchars($row["teacher_last_name"]); ?></td>
                    <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($birth_date))); ?></td>
                    <td><?php echo htmlspecialchars($age); ?></td>
                    <td><?php echo htmlspecialchars($row["course_name"]); ?></td>
                    <td><?php echo htmlspecialchars($enrolled_students); ?></td>
                    <td>
                        <a class="btn btn-success" href="update.php?ID=<?php echo htmlspecialchars($row["teacher_id"]); ?>">Update</a>
                        <a class="btn btn-danger" href="delete.php?ID=<?php echo htmlspecialchars($row["teacher_id"]); ?>">Delete</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    } else {
        echo "No existen maestros con cursos asignados";
    }
    ?>
</div>

<div class="container jumbotron">
    <?php
    // Verifica si hay cursos en la base de datos
    // Consulta para obtener los cursos y sus maestros
$sql = "SELECT course.course_id, course.course_name, course.description, course.teacher_id, 
teacher.full_name, teacher.last_name
FROM course
LEFT JOIN teacher ON course.teacher_id = teacher.teacher_id";

$result = mysqli_query($conn, $sql);

// Verifica si hay cursos en la base de datos
if (mysqli_num_rows($result) > 0) {
?>
<div class="container jumbotron">
<h2>Listado de Cursos</h2>
<table>
<tr>
 <td>Código del Curso</td>
 <td>Nombre del Curso</td>
 <td>Descripción</td>
 <td>Maestro Asignado</td>
 <td>Acciones</td>
</tr>
<?php
// Mostrar los cursos y los maestros
while ($row = mysqli_fetch_array($result)) {
 $teacher_name = isset($row["full_name"]) && isset($row["last_name"]) 
                 ? $row["full_name"] . " " . $row["last_name"] 
                 : "Sin maestro asignado";
 ?>
 <tr>
     <td><?php echo htmlspecialchars($row["course_id"]); ?></td>
     <td><?php echo htmlspecialchars($row["course_name"]); ?></td>
     <td><?php echo htmlspecialchars($row["description"]); ?></td>
     <td><?php echo htmlspecialchars($teacher_name); ?></td>
     <td>
         <a class="btn btn-danger" href="deleteCourse.php?ID=<?php echo htmlspecialchars($row["course_id"]); ?>">Delete</a>
     </td>
 </tr>
 <?php
}
?>
</table>
</div>
<?php
} else {
echo "<div class='container jumbotron'><h2>No existen cursos</h2></div>";
}
?>



<?php
include_once 'components/footer.php';
?>
