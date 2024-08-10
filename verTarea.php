<?php
include './config/conexion.php';

// Verifica si se recibió el codigoTarea correctamente
if (isset($_POST['codigoTarea_ct'])) {
    $idTarea = $_POST['codigoTarea_ct'];

    // Prepara la consulta SQL
    $query_tarea = "SELECT 
        e.nombre AS nombreEmpleado, 
        t.codigoTarea, 
        t.fechaini, 
        t.fechafz,
        t.planes, 
        t.descripcion,
        t.estado,
        c.cedula,
        c.nombre,
        c.email,
        c.telefono
    FROM tarea t 
    JOIN tareas_empleados te ON te.codigoTarea = t.codigoTarea 
    JOIN empleado e ON te.idempleado = e.idEmpleado 
    JOIN clientes c ON t.cedula = c.cedula 
    WHERE t.codigoTarea = ?";

    // Ejecuta la consulta preparada
    $stmt = $con->prepare($query_tarea);
    $stmt->bind_param('i', $idTarea);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica si se obtuvieron resultados
    if ($result && $result->num_rows > 0) {
        // Obtiene la fila de resultados
        $row = $result->fetch_assoc();

        // Crea un array asociativo con los datos obtenidos
        $Vtarea = [
            'codigoTarea' => $row['codigoTarea'],
            'nombreEmpleado' => $row['nombreEmpleado'],
            'planes' => $row['planes'],
            'fechaini' => $row['fechaini'],
            'fechafz' => $row['fechafz'],
            'nombre' => $row['nombre'],
            'email' => $row['email'],
            'telefono' => $row['telefono'],
            'estado' => $row['estado'],
            'descripcion' => $row['descripcion'],
            'cedula' => $row['cedula'],
        ];

        // Convierte el array a formato JSON y lo imprime
        echo json_encode($Vtarea);
    } else {
        // No se encontraron resultados
        echo json_encode(['error' => 'No se encontraron resultados para el código de tarea proporcionado']);
    }
}
?>
