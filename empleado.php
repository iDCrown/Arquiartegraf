<?php
include "./config/conexion.php";
// EMPLEADOS
    if(isset($_POST['enviarEmpleado'])){
    $idEmpleado = mysqli_real_escape_string($con, $_POST['idEmpleado']);
    $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $telefono = mysqli_real_escape_string($con, $_POST['telefono']);
    $direccion = mysqli_real_escape_string($con, $_POST['direccion']);
    $cargo = mysqli_real_escape_string($con, $_POST['cargo']);
 


      //Configurar tiempo zona horaria
    date_default_timezone_set('America/Bogota');
    $time = date('h:i:s a', time());

      //Validar si no están vacíos
    if(!isset($idEmpleado) || $idEmpleado == '' || !isset($nombre) || $nombre == '' || !isset($telefono) || $telefono == '' || !isset($email) || $email == '' || !isset($direccion) || $direccion == '' || !isset($cargo) || $cargo == ''){
        $error = "Algunos campos están vacíos";
    }else{
        $query = "INSERT INTO empleado(idEmpleado, nombre, email, telefono, direccion,cargo)VALUES('$idEmpleado', '$nombre', '$email', '$telefono', '$direccion', ' $cargo')";

        if(!mysqli_query($con, $query)){
          die('Error: ' . mysqli_error($con));
          $error = "Error, no se pudo crear el registro";
      }else{
          $mensaje = "Registro creado correctamente";
          header('Location: index.php?mensaje='.urlencode($mensaje));
          exit();
      }
  }
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleado</title>
    <link rel="stylesheet" href="./css/crear.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <div class="conteiner">
    <div class="content">
      <div style="display: flex; justify-content: center;">
        <div class="abogado"  style="">
          <h2 class="h2_crear">Empleado</h2>
          <p class="p_crear" >Ingrese la información del Empleado</p>
          <div style="margin-top: 22px">  
          <form class="conteiner-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="forml1">
              <div class="first mb-3">
                <label for="idEmpleado" class="form-label">Cedula</label>
                <input type="number" class="for  b1" name="idEmpleado" id="exampleInputEmail1" aria-describedby="emailHelp">
              </div>
              <div class="first mb-3">
                <label for="nombre" class="form-label">Nombre Completo</label>
                <input type="text" class=" for  b1" name="nombre" id="exampleInputPassword1">
              </div>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Correo Electronico</label>
              <input type="email" class="for b2" name="email" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
              <label for="telefono" class="form-label">Numero Telefonico</label>
              <input type="number" class="for b2" name="telefono" id="exampleInputPassword1">
            </div>
            <div class="forml1">
              <div class="first mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="for b3" name="direccion" id="exampleInputPassword1">
              </div>  
              <div class="first mb-3">
                <label for="cargo" class="form-label">Cargo</label>
                <input type="text" class="for b3" name="cargo" id="exampleInputPassword1">
              </div>  
            </div>  
            <button type="submit" class="btn-brown" name="enviarEmpleado">Enviar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>