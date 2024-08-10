<?php include "tareasCon.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CREAR</title>
    <link rel="stylesheet" href="./css/casos.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  </head>
<body>
  <div class="containerr text-center">
    <div class="row content align-items-center">
      <div class="col col-5 clientes">
        <a href="index.php">
          <img style="position: absolute; top: 24px; left: 31px; width: 44px;" src="./icon/flecha.png" alt="">
        </a>
        <h2 class="fs-2"><?php echo $fila['nombre']; ?></h2>
        <p class="parraf">Datos del cliente</p>
        <div style="margin-bottom: 8em">
          <div class="hstack gap-3">
            <div class="p-2 title">cedula</div>
            <div class="vrr"></div>
            <div class="p-2 subt ms-auto"><?php echo $fila['cedula']; ?></div>
          </div>
          <div class="hstack gap-3">
            <div class="p-2 title">telefono</div>
            <div class="vrr"></div>
            <div class="p-2 subt ms-auto"><?php echo $fila['telefono']; ?></div>
          </div>
          <div class="hstack gap-3">
            <div class="p-2 title">email</div>
            <div class="vrr"></div>
            <div class="p-2 subt ms-auto"><?php echo $fila['email']; ?></div>
          </div>
          <div class="hstack gap-3">
            <div class="p-2 title">direccion</div>
            <div class="vrr"></div>
            <div class="p-2 subt ms-auto"><?php echo $fila['direccion']; ?></div>
          </div>
        </div>

        <div class="buton">
          <button type="button" class="btn-brown" data-bs-toggle="modal" data-bs-target="#exampleModal" >Editar</button>
        </div>
      <!-- MODAL -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                
                <form class="conteiner-modal" method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?cedula=' . $fila['cedula']; ?>">
                  <div class="forml1">
                    <div class="first mb-3">
                      <label for="cedula" class="form-labe">Cedula</label>
                      <input type="number" class="for" name="cedula" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $fila['cedula']; ?>">
                    </div>
                    <div class="first mb-3">
                      <label for="nombre" class="form-labe">Nombre Completo</label>
                      <input type="text" class=" for" name="nombre" id="exampleInputPassword1"  value="<?php echo $fila['nombre']; ?>">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-labe">Correo Electronico</label>
                    <input type="email" class="for b1" name="email" id="exampleInputPassword1"  value="<?php echo $fila['email']; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="telefono" class="form-labe">Numero Telefonico</label>
                    <input type="number" class="for b2" name="telefono" id="exampleInputPassword1"  value="<?php echo $fila['telefono']; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="direccion" class="form-labe">Dirección</label>
                    <input type="text" class="for b3" name="direccion" id="exampleInputPassword1"  value="<?php echo $fila['direccion']; ?>">
                  </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn-brown" name="editarRegistro">Editar Registro</button>                  
                    <button type="button" class="btn-brown" data-bs-dismiss="modal">Cerrar</button>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Tarea -->
      <div class="col background elemento">
        <h2 class="h2_crear">Tarea</h2>
        <p class="p_crear" >Ingrese la información del proyecto que desea solicitar</p>
        <div style="margin-top: 22px">  
          <form class="conteiner-form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?cedula=' . $fila['cedula']; ?>">

            <div class="forml1">
              <div class="first mb-3">
                <label for="codigoTarea" class="form-label">Código</label>
                <input type="number" class="for" name="codigoTarea" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $codigoTarea; ?>" readonly>
              </div>
              <div class="first mb-3">
                <label for="idEmpleado" class="form-label">Empleado</label>
                <input type="number" class="for" name="idEmpleado" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $idEmpleado; ?>">
              </div>
            </div>
            <div class="forml1">
              <div class="first mb-3">
                <label for="fechaini" class="form-label">Fecha de Inicio</label>
                <input type="date" class=" for"  name="fechaini">
              </div>
              <div class="first mb-3">
                
                <label for="fechafz" class="form-label">Fecha de Entrega</label>
                <input type="date" class=" for"  name="fechafz">
              </div>
            </div>

            <div class="forml1">
              <div class="first mb-3">
              <label for="planes" class="form-label">Tipo de Plan</label>
                <select class="form-select for" name="planes" aria-label="Default select example">
                <option value="Diseño-Plan Basico">Diseño - Plan Basico Identidad esencial</option>
                  <option value="Diseño-Plan Premium ">Diseño - Plan Premium Marca Completa </option>
                  <option value="Arquitectura-Plan esencial">Arquitectura - Plan esencial</option>
                  <option value="Arquitectura-Plan Integral">Arquitectura - Plan Integral </option>
              </select>
              </div>

              <div class="first mb-3">
              <label for="estado" class="form-label">Estado</label>
                <select class="form-select  for" name="estado" aria-label="Default select example">
                  <option value="creado">Creado</option>
                  <option value="en progreso">En progreso</option>
                  <option value="en pausa">En Pausa</option>
                  <option value="finalizado">Finalizado</option>
              </select>
              </div>
            </div>
              <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Descripcion del Proyecto</label>
                <textarea class="form-control " name="descripcion" style="background: #f1e1ff; margin-bottom: 2em;" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div>
            <button type="submit" class="btn-brown warning" name="enviarTarea">Enviar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>

