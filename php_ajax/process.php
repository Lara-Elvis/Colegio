<?php
include_once 'backend/database.php';

// Read POST data
$data = json_decode(file_get_contents("php://input"));

if (isset($data)) {

    $id = $data->id;
    $first_name = $data->firstName;
    $last_name = $data->lastName;
    $type = $data->type;

    if ($type == 1) {

        $sql = "INSERT INTO student (identifier, Last_Name, First_Name)
	 VALUES ($id, '$last_name', '$first_name')";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("success"=>true, "message"=>"Estudiante creado con éxito."));
        } else {
            echo json_encode(array("success"=>false, "message"=>"Error: " . $sql . " " . mysqli_error($conn)));
        }
        mysqli_close($conn);
    } else if ($type == 2) {

        $sql = "UPDATE student SET 
                Last_Name = '$last_name', First_Name = '$first_name'
                WHERE identifier = $id";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("success"=>true, "message"=>"Estudiante actualizado con éxito."));
        } else {
            echo json_encode(array("success"=>false, "message"=>"Error: " . $sql . " " . mysqli_error($conn)));
        }
        mysqli_close($conn);
    } else if ($type == 3) {

        $sql = "DELETE FROM student 
                WHERE identifier = $id";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("success"=>true, "message"=>"Estudiante borrado con éxito."));
        } else {
            echo json_encode(array("success"=>false, "message"=>"Error: " . $sql . " " . mysqli_error($conn)));
        }
        mysqli_close($conn);
    }
}
?>