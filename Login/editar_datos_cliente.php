<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión, en caso contrario redirige al formulario de inicio de sesión
if (!isset($_SESSION['idUsuario'])) {
  header("Location: login.php");
  exit();
}

// Realiza la conexión a la base de datos
include('../database/db.php');

// Obtiene el ID del usuario almacenado en la sesión
$idUsuario = $_SESSION['idUsuario'];

// Obtiene los datos del cliente asociados al usuario
$consultaCliente = "SELECT * FROM cliente WHERE idUsuario = '$idUsuario'";
$resultadoCliente = mysqli_query($conn, $consultaCliente);
$datosCliente = mysqli_fetch_assoc($resultadoCliente);

// Verifica si se ha enviado el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $direccion = $_POST['direccion'];
  $telefono = $_POST['telefono'];

  // Actualiza los datos del cliente en la base de datos
  $consultaUpdate = "UPDATE cliente SET nombre = '$nombre', apellido = '$apellido', direccion = '$direccion', telefono = '$telefono' WHERE idCliente = {$datosCliente['idCliente']}";
  mysqli_query($conn, $consultaUpdate);

  // Redirige a la página de vista general
  header("Location: vista_general.php");
  exit();
}

// Cierra la conexión a la base de datos
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
  <title>ParkioGO - Editar Cliente</title>
  <link rel="Website Icon" type="png" href="../Recursos/LOGO-GRANDE.png"> <!--ICONO DE LA PAGINA-->
  <link rel="stylesheet" type="text/css" href="../css/datoCliente.css">
  <style>
    .container {
      padding: 20px;
    }

    .container form {
      display: grid;
      gap: 10px;
    }

    .container form label {
      font-weight: bold;
    }

    .container form input[type="text"],
    .container form input[type="email"] {
      padding: 5px;
    }

    .container form button {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
    }

    .container form button:hover {
      background-color: #0069d9;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Editar Datos del Cliente</h2>
    <form method="POST" action="editar_datos_cliente.php">
      <div>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $datosCliente['nombre']; ?>" required>
      </div>
      <div>
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" value="<?php echo $datosCliente['apellido']; ?>" required>
      </div>
      <div>
        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" value="<?php echo $datosCliente['direccion']; ?>" required>
      </div>
      <div>
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo $datosCliente['telefono']; ?>" required>
      </div>
      <div>
        <button type="submit" class="btn-editar-cliente">Guardar Cambios</button>
      </div>
    </form>
  </div>
</body>
</html>
