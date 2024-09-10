function searchId(newId) {

    txtIdMessage = document.getElementById("idMessage");
    txtNewId = document.getElementById("id");
    btnSaveStudent = document.getElementById("sendStudentData");

    if (newId.length == 0) {
        txtNewId.innerHTML = "";
        txtIdMessage.innerHTML = "";
        btnSaveStudent.disabled = true;
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                response = JSON.parse(this.responseText);

                if (response.success) {
                    txtIdMessage.classList.add("warning");
                    txtIdMessage.classList.remove("success");
                    btnSaveStudent.disabled = true;
                } else {
                    txtIdMessage.classList.add("success");
                    txtIdMessage.classList.remove("warning");
                    btnSaveStudent.disabled = false;
                }
                txtIdMessage.innerHTML = response.message;
            }
        };
        xmlhttp.open("GET", "backend/searchNewId.php?newId=" + newId, true);
        xmlhttp.send();
    }

}

function sendData() {
    newId = document.getElementById("id").value;
    firstName = document.getElementById("firstName").value;
    lastName = document.getElementById("lastName").value;
    type = document.getElementById("type").value;

    var data = {id: newId, firstName: firstName, lastName: lastName, type: type};

    mdlMessage = document.getElementById("messageModal");

    txtmdlMessage = document.getElementById("mdlMessage");
    txtmdlSuccess = document.getElementById("mdlSuccess");

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            response = JSON.parse(this.responseText);

            txtmdlSuccess.value = response.success;
            txtmdlMessage.innerHTML = response.message;
        }
    };
    xmlhttp.open("POST", "process.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/json");
    xmlhttp.send(JSON.stringify(data));
}

function cleanData() {
    mdlSuccess = document.getElementById("mdlSuccess").value;
    type = document.getElementById("type").value;
    console.log(type);
    if (type == "1") {
        if (mdlSuccess == "true") {
            document.getElementById("idMessage").innerHTML = "";
            document.getElementById("id").value = "";
            document.getElementById("firstName").value = "";
            document.getElementById("lastName").value = "";
        }
    } else {
        location.href = "read.php";
    }
}

function sendDataTeacher() {
    // Obtener los datos del formulario
    var id = document.getElementById("id").value;
    var firstName = document.getElementById("firstName").value;
    var lastName = document.getElementById("lastName").value;
    var birthDate = document.getElementById("birthDate").value;
    var type = document.getElementById("type").value;

    // Crear el objeto de datos que se va a enviar
    var data = {
        id: id,
        fullName: firstName + " " + lastName, // Combinar nombres y apellidos
        birthDate: birthDate,
        type: type
    };

    // Configurar el AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "processTeacher.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    // Respuesta del servidor
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Parsear la respuesta del servidor
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert(response.message); // Muestra el mensaje de éxito
            } else {
                alert(response.message); // Muestra el mensaje de error
            }
        }
    };

    // Enviar los datos
    xhr.send(JSON.stringify(data));
}