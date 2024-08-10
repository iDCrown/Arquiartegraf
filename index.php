<?php include './config/conexion.php'; ?>
<?php include 'verTarea.php';?>
<?php
    //Crear y seleccionar query de clientes
    $query = "SELECT * FROM clientes ORDER BY cedula DESC";
    $clientes = mysqli_query($con, $query);

    if(isset($_POST['borrar'])){        
      $idRegistro = $_POST['cedula'];
      //Validar si no están vacíos
      $query = "DELETE FROM clientes WHERE cedula='$idRegistro'";

        if(!mysqli_query($con, $query)){
        
          die('Error: ' . mysqli_error($con));
          $error = "Error, no se pudo crear el registros";
        }else{
          $mensaje = "Registro borrado correctamente";
          header('Location: index.php?mensaje='.urlencode($mensaje));
          exit();
        }
    }


    if(isset($_POST['borrarTarea'])){        
      $idRegistro = $_POST['codigoTarea'];
      //Validar si no están vacíos
      $query = "DELETE FROM tarea WHERE codigoTarea= ?";

      $stmt = $con->prepare($query);
      $stmt->bind_param("i", $idRegistro);
      $stmt->execute();
      $result = $stmt->get_result();
        if($result->num_rows>0){
        
          die('Error: ' . mysqli_error($con));
          $error = "Error, no se pudo crear el registros";
        }else{
          $mensaje = "Registro borrado correctamente";
          header('Location: index.php?mensaje='.urlencode($mensaje));
          exit();
        }
    }
    // Empleados
    $query = "SELECT * FROM empleado ORDER BY idEmpleado DESC";
    $empleados = mysqli_query($con, $query);

    if(isset($_POST['borrarEmpleado'])){        
    $idRegistro = $_POST['idEmpleado'];
    //Validar si no están vacíos
    $query = "DELETE FROM empleado WHERE idEmpleado='$idRegistro'";

    if(!mysqli_query($con, $query)){
    
      die('Error: ' . mysqli_error($con));
      $error = "Error, no se pudo crear el registros";
      }else{
      $mensaje = "Registro borrado correctamente";
      header('Location: index.php?mensaje='.urlencode($mensaje));
      exit();
      }
    }

  

  // HISTORIAL DE TAREAS
 // Tareas
$result = null;

if (isset($_GET['cedula'])) {
  $idCedula = $_GET['cedula'];

  $query_historialTarea = "SELECT 
  e.nombre AS nombreEmpleado, 
  t.codigoTarea, 
  t.fechaini,
  t.fechafz, 
  t.planes, 
  t.estado 
  FROM tarea t 
  JOIN tareas_empleados te 
  ON te.codigoTarea = t.CodigoTarea 
  JOIN empleado e 
  ON te.idEmpleado = e.idEmpleado 
  JOIN clientes cl 
  ON t.cedula = cl.cedula 
  WHERE t.cedula = ?
  GROUP BY t.CodigoTarea, e.nombre, t.planes, t.estado";
  
  // Preparar la declaración
  $stmt = $con->prepare($query_historialTarea);
  // Vincular los parámetros
  $stmt->bind_param('s', $idCedula); // 's' indica que el parámetro es de tipo string
  // Ejecutar la declaración
  $stmt->execute();
  // Obtener los resultados
  $result = $stmt->get_result();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="./index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <ul class="nav nav-tabs" style="padding: 1em;border-bottom: 2px solid #3b2983;background: #121652;">
    <li class="nav-item">
      <a class="nav-link" style="border: none; color: #ffffff; font-variant-caps: all-petite-caps; font-weight: 900; letter-spacing: 1px;" aria-current="page"  href="#" onclick="mostrarTabla('clientes')">Clientes</a>
    </li>
    <li class="nav-item">
      <a class="nav-link"style="border: none; color: #ffffff; font-variant-caps: all-petite-caps; font-weight: 900; letter-spacing: 1px;" href="#" onclick="mostrarTabla('tareas')">Historial de tareas</a>
    </li>
    <li class="nav-item">
      <a class="nav-link"style="border: none; color: #ffffff; font-variant-caps: all-petite-caps; font-weight: 900; letter-spacing: 1px;" href="#" onclick="mostrarTabla('empleado')">Empleados</a>
    </li>
  </ul>
  <div class="conteiner elemento">
    <div class="content">
      <!-- Tabla de clientes -->
      <div id="clientes" style="display: block;">
        <!-- Boton Crear Cliente -->
        <div class="boton">
          <a href="crearCliente.php" class=""> 
            <button type="button" class=" btn" style="border: 2px solid #8004e3; color: #8004e3;">Crear Cliente</button>
          </a>
        </div>
        <table class="table table-hover;" style="border: 6px solid #3b2983">
          <thead class="table table-dark table-hover">
            <tr>
              <th scope="col" style="background: #6c3fc56b;">Cedula</th>
              <th scope="col" style="background: #6c3fc56b;">Nombre</th>
              <th scope="col" style="background: #6c3fc56b;">Correo</th>
              <th scope="col" style="background: #6c3fc56b;">Telefono</th>
              <th scope="col" style="background: #6c3fc56b;">Direccion</th>
              <th scope="col" style="background: #6c3fc56b;"></th>
            </tr>
          </thead>
          <tbody>
          <?php while ( $fila = mysqli_fetch_assoc($clientes)) : ?>
            <tr class="tr-row" style="font-size: smaller">
              <td scope="row" style="color: white; background: bottom; padding: 1rem;">
                <a style="color: #9d55c2;" href="tareas.php?cedula=<?php echo $fila['cedula']; ?>">
                  <?php echo $fila['cedula']; ?>
                </a>
              </td>
              <td scope="row" style="color: white; background: bottom; padding: 1rem;"><?php echo $fila['nombre']; ?></td>
              <td scope="row" style="color: white; background: bottom; padding: 1rem;"><?php echo $fila['email']; ?></td>
              <td scope="row" style="color: white; background: bottom; padding: 1rem;"><?php echo $fila['telefono']; ?></td>
              <td scope="row" style="color: white; background: bottom; padding: 1rem;"><?php echo $fila['direccion']; ?></td>
              <td scope="row" style="color: white; background: bottom; padding: 1rem;">
              <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="cedula" value="<?php echo $fila['cedula']; ?>">
                <button type="submit" class="btn w-100" style="background: #8d19c8; border: 2px; color: white;" name="borrar">Borrar</button>
              </form>
            </tr> 
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
       <!-- Empleado -->
       <div id="empleado"  style="display: none;">
        <!-- Boton Crear  -->
        <div class="boton">
          <a href="empleado.php" class=""> 
            <button type="button" class=" btn" style="border: 2px solid #8004e3; color: #8004e3;">Crear Empleado</button>
          </a>
        </div>
          <!-- tabla Empleados -->
        <table class="table table-hover " style="border: 6px solid #3b2983">
          <thead class="table table-dark table-hover" >
            <tr>
              <th scope="col" style="background: #6c3fc56b;" >Cedula</th>
              <th scope="col" style="background: #6c3fc56b;" >Nombre</th>
              <th scope="col" style="background: #6c3fc56b;" >Correo</th>
              <th scope="col" style="background: #6c3fc56b;" >Telefono</th>
              <th scope="col" style="background: #6c3fc56b;" >Direccion</th>
              <th scope="col" style="background: #6c3fc56b;" >Cargo</th>
              <th scope="col" style="background: #6c3fc56b;" ></th>
            </tr>
          </thead>
          <tbody>
          <?php while ( $fila = mysqli_fetch_assoc($empleados)) : ?>
            <tr class="tr-row" style="font-size: smaller">
              <td scope="row" style="color: white; background: bottom; padding: 1rem;">
                <?php echo $fila['idEmpleado']; ?>
              </td>
              <td scope="row" style="color: white; background: bottom; padding: 1rem;"><?php echo $fila['nombre']; ?></td>
              <td scope="row" style="color: white; background: bottom; padding: 1rem;"><?php echo $fila['email']; ?></td>
              <td scope="row" style="color: white; background: bottom; padding: 1rem;"><?php echo $fila['telefono']; ?></td>
              <td scope="row" style="color: white; background: bottom; padding: 1rem;"><?php echo $fila['direccion']; ?></td>
              <td scope="row" style="color: white; background: bottom; padding: 1rem;"><?php echo $fila['cargo']; ?></td>
              <td scope="row" style="color: white; background: bottom; padding: 1rem;">
              <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="idEmpleado" value="<?php echo $fila['idEmpleado']; ?>">
                <button type="submit" class="btn w-100" style="background: #8d19c8; border: 2px; color: white;" name="borrarEmpleado">Borrar</button>
              </form>
            </tr> 
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
      <!-- tabla tareas -->
      <div id="tareas" style="display:none;">
          <form class="consultar" action="" method="GET">
          <p  style="color:white" class="p_crear">Ingrese el ID del cliente</p>
            <input class="input" type="text" name="cedula">
            <button type="submit" style="border: 2px solid #8004e3;color: #8004e3;background: transparent;" class="button" name="consultar">buscar</button>
          </form>
          <table class="table table-hover"  style="border: 6px solid #3b2983">
            <thead class="table table-dark table-hover" >
              <tr>
                <th scope="col" style="background: #6c3fc56b;">Código</th>
                <th scope="col" style="background: #6c3fc56b;">Empleado a cargo</th>
                <th scope="col" style="background: #6c3fc56b;">Fecha de inicio</th>
                <th scope="col" style="background: #6c3fc56b;">fecha de entrega</th>
                <th scope="col" style="background: #6c3fc56b;">Plan</th>
                <th scope="col" style="background: #6c3fc56b;">Estado</th>
                <th scope="col" style="background: #6c3fc56b;"></th>
              </tr>
            </thead>
            <tbody>
            <?php if ($result): ?>
              <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr class="tr-row" style="font-size: smaller">
                  <td scope="row"  style="color: white; background: bottom; padding: 1rem;"><?php echo $row['codigoTarea']; ?></td>
                  <td scope="row"  style="color: white; background: bottom; padding: 1rem;"><?php echo $row['nombreEmpleado']; ?></td>
                  <td scope="row"  style="color: white; background: bottom; padding: 1rem;"><?php echo $row['fechaini']; ?></td>
                  <td scope="row"  style="color: white; background: bottom; padding: 1rem;"><?php echo $row['fechafz']; ?></td>
                  <td scope="row"  style="color: white; background: bottom; padding: 1rem;"><?php echo $row['planes']; ?></td>
                    <td scope="row"  style="color: white; background: bottom; padding: 1rem;"><?php echo $row['estado']; ?></td>
                    <td scope="row"  style="color: white; background: bottom; padding: 1rem;">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                      <div class="forml1">
                        <button type="button" class="btn w-100" style="margin-right: 9px; background: #8d19c8; border: 2px; color: white;"  data-expediente="<?php echo $row['codigoTarea']; ?>" onclick="verTarea(this)" data-bs-toggle="modal" data-bs-target="#myModal">Ver</button>

                        <input type="hidden" name="codigoTarea" value="<?php echo $row['codigoTarea']; ?>">
                        <button type="submit" class="btn w-100" style="background: #8d19c8; border: 2px; color: white;" name="borrarTarea">Borrar</button>
                      </div>
                    </form>
                </tr> 
              <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5">No se encontraron registros.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>          
     
      <!-- Modal Tareas -->
      <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modalFactura-header">
        <div>
          <p class="modalFactura-title" id="exampleModalLabel">Tarea #<span id="codigoTarea"></span></p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>  
      <div class="tableFactura-header">
        <div class="infoMascota">
          <h2 class="title_mascota" id="nombre"></h2>
          <table class="data-table">
            <tr>
              <th>Cédula:</th><td id="cedula"></td>
            </tr>
            <tr>
              <th>Teléfono:</th><td id="telefono"></td>
            </tr>
            <tr>
              <th>Email:</th><td id="email"></td>
            </tr>
          </table>
        </div>
        <div class="column_Nfactura">
          <table class="data-table">
            <tr>
              <th class="facturaN">Fecha Inicio:</th><td id="fechaini"></td>
            </tr>
            <tr>
              <th class="facturaN">Fecha Final:</th><td id="fechafz"></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="modal-body">
        <table class="table table-sm caption-top">
          <h2 class="casoFactura-title">Información del Proyecto</h2>
          <thead>
            <tr>
              <th scope="col">Tarea</th>
              <th scope="col">Planes</th>
              <th scope="col">Empleado Asignado</th>
              <th scope="col">Estado</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            <tr>
              <td id="codigoTarea_ct"></td>
              <td id="planes"></td>
              <td id="nombreEmpleado"></td>
              <td id="estado"></td>
            </tr>
          </tbody>
        </table>
        <p style="margin-top: 32px;"><strong>Descripción de la Tarea:</strong></p>
        <p class="text_descripcion" id="descripcion">Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo, amet.</p>
      </div>
    </div>
  </div>
</div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <script>
  function verTarea(button) {
    const codigoTarea = button.getAttribute('data-expediente');

    // Realizar una solicitud AJAX a verTarea.php
    fetch('verTarea.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: 'codigoTarea_ct=' + codigoTarea
    })
    .then(response => response.json())
    .then(data => {
      if (data.error) {
        alert(data.error);
      } else {
        // Poblar el modal con los datos recibidos
        document.getElementById('codigoTarea').innerText = data.codigoTarea;
        document.getElementById('codigoTarea_ct').innerText = data.codigoTarea;
        document.getElementById('nombre').innerText = data.nombre; // Nombre del cliente
        document.getElementById('cedula').innerText = data.cedula; 
        document.getElementById('telefono').innerText = data.telefono;
        document.getElementById('email').innerText = data.email;
        document.getElementById('fechaini').innerText = data.fechaini;
        document.getElementById('fechafz').innerText = data.fechafz;
        document.getElementById('planes').innerText = data.planes;
        document.getElementById('nombreEmpleado').innerText = data.nombreEmpleado; // Nombre del empleado
        document.getElementById('estado').innerText = data.estado;
        document.getElementById('descripcion').innerText = data.descripcion;
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
  }
</script>

  <script>
    function mostrarTabla(tabla) {
      const tablas = ['clientes', 'tareas', 'empleado'];
      tablas.forEach(t => {
        document.getElementById(t).style.display = (t === tabla) ? 'block' : 'none';
      });
    }
  </script>

</body>
</html>