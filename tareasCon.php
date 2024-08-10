<?php
  // Incluimos conexión
    include './config/conexion.php';

  // Obtener el ID del cliente de la URL
    if (isset($_GET['cedula']) && !empty($_GET['cedula'])) {
    $idRegistro = $_GET['cedula'];
    } else {
    die("Error: Cedula parameter is missing in the URL.");
    }

  // Generar un Código de tarea aleatorio
    $codigoTarea = rand(1000, 9999);

  // Prepare and execute the query to fetch client data
  $query = "SELECT * FROM clientes WHERE cedula = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $idRegistro);
    $stmt->execute();
    $result = $stmt->get_result();

  // Verificar si se encontró el cliente
    if ($result->num_rows > 0) {
    $fila = $result->fetch_assoc();
    } else {
    die("Error: Cliente no encontrado.");
    }

  // Verificar si se ha enviado el formulario de edición
    if (isset($_POST['editarRegistro'])) {
    $idRegistro = $_POST['cedula'];
    // Obtener los datos del formulario
    $cedula = mysqli_real_escape_string($con, $_POST['cedula']);
    $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $telefono = mysqli_real_escape_string($con, $_POST['telefono']);
    $direccion = mysqli_real_escape_string($con, $_POST['direccion']);

    // Validar si no están vacíos
    if (!empty($cedula) && !empty($nombre) && !empty($email) && !empty($telefono) && !empty($direccion)) {
      // Actualizar los datos del cliente en la base de datos
        $query = "UPDATE clientes SET cedula=?, nombre=?, email=?, telefono=?, direccion=? WHERE cedula=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sssssi", $cedula, $nombre, $email, $telefono, $direccion, $idRegistro);
        if ($stmt->execute()) {
        $mensaje = "Registro editado correctamente";
        // Recargar los datos del cliente después de la edición
        $result = $con->query("SELECT * FROM clientes WHERE cedula='$cedula'");
        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
        } else {
            die("Error: Cliente no encontrado.");
        }
        } else {
            die("Error: No se pudo editar el registro.");
        }
    } else {
        die("Error: Algunos campos están vacíos.");
    }
    }

  // Verificar si se ha enviado el formulario de creación de la tarea
  if (isset($_POST['enviarTarea'])) {
    echo 'cedula' . $idRegistro;

    $codigoTarea = mysqli_real_escape_string($con, $_POST['codigoTarea']);
    $fechaini = mysqli_real_escape_string($con, $_POST['fechaini']);
    $fechafz = mysqli_real_escape_string($con, $_POST['fechafz']);
    $planes = mysqli_real_escape_string($con, $_POST['planes']); // Renombrado de tipoCaso a planes
    $estado = mysqli_real_escape_string($con, $_POST['estado']);
    $descripcion = mysqli_real_escape_string($con, $_POST['descripcion']);
    $idEmpleado = mysqli_real_escape_string($con, $_POST['idEmpleado']);

    // Validar si no están vacíos
    if (!empty($codigoTarea) && !empty($fechaini) && !empty($fechafz) && !empty($planes) && !empty($estado) && !empty($descripcion)) {
        // Insertar en la tabla tarea
        $query = "INSERT INTO tarea(codigoTarea, fechaini, fechafz, planes, estado, descripcion, cedula) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("isssssi", $codigoTarea, $fechaini, $fechafz, $planes, $estado, $descripcion, $idRegistro);
        $stmt->execute();

        // Insertar en la tabla tareas_empleados
        $query_tareas_empleados = "INSERT INTO tareas_empleados(codigoTarea, idEmpleado) VALUES (?, ?)";
        $stmt_tareas_empleados = $con->prepare($query_tareas_empleados);
        $stmt_tareas_empleados->bind_param("ii", $codigoTarea, $idEmpleado);
        $stmt_tareas_empleados->execute();

        if ($stmt_tareas_empleados->error) {
            die('Error: ' . $stmt_tareas_empleados->error);
        }
    }

    header('Location: index.php?mensaje=' . urlencode("Tarea programada correctamente"));
    exit();
}

?>
