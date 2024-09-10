<?php
include_once 'backend/database.php';

// Leer los datos enviados por POST
$data = json_decode(file_get_contents("php://input"));

if (isset($data)) {

    $teacher_id = $data->id;
    $full_name = $data->fullName;
    $birth_date = $data->birthDate; // Esperado en formato DD/MM/YYYY
    $type = $data->type;

    // Validar el formato de la fecha de nacimiento
    if (preg_match("/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/", $birth_date)) {
        // Convertir la fecha de nacimiento al formato MySQL (YYYY-MM-DD)
        $date_parts = explode("/", $birth_date);
        $birth_date_mysql = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];

        if ($type == 1) { // Insertar nuevo maestro

            $sql = "INSERT INTO teacher (teacher_id, full_name, birth_date)
            VALUES ($teacher_id, '$full_name', '$birth_date_mysql')";

            if (mysqli_query($conn, $sql)) {
                echo json_encode(array("success" => true, "message" => "Maestro creado con éxito."));
            } else {
                echo json_encode(array("success" => false, "message" => "Error: " . $sql . " " . mysqli_error($conn)));
            }
            mysqli_close($conn);

        } else if ($type == 2) { // Actualizar maestro existente

            $sql = "UPDATE teacher SET
                    full_name = '$full_name',
                    birth_date = '$birth_date_mysql'
                    WHERE teacher_id = $teacher_id";

            if (mysqli_query($conn, $sql)) {
                echo json_encode(array("success" => true, "message" => "Maestro actualizado con éxito."));
            } else {
                echo json_encode(array("success" => false, "message" => "Error: " . $sql . " " . mysqli_error($conn)));
            }
            mysqli_close($conn);

        } else if ($type == 3) { // Eliminar maestro

            $sql = "DELETE FROM teacher WHERE teacher_id = $teacher_id";

            if (mysqli_query($conn, $sql)) {
                echo json_encode(array("success" => true, "message" => "Maestro eliminado con éxito."));
            } else {
                echo json_encode(array("success" => false, "message" => "Error: " . $sql . " " . mysqli_error($conn)));
            }
            mysqli_close($conn);
        }

    } else {
        echo json_encode(array("success" => false, "message" => "Formato de fecha de nacimiento incorrecto. Debe ser DD/MM/YYYY."));
    }
}
?>