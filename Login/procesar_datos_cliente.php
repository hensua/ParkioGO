<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión, en caso contrario redirige al formulario de inicio de sesión
if (!isset($_SESSION['idUsuario'])) {
  header("Location: login.php");
  exit();
}

// Obtiene el ID del usuario almacenado en la sesión
$idUsuario = $_SESSION['idUsuario'];

// Realiza la conexión a la base de datos
include('../database/db.php');

// Procesa los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $direccion = $_POST['direccion'];
  $telefono = $_POST['telefono'];

  // Consulta SQL para insertar los datos del cliente en la base de datos
  $consulta = "INSERT INTO cliente (idUsuario, nombre, apellido, direccion, telefono) VALUES ('$idUsuario', '$nombre', '$apellido', '$direccion', '$telefono')";
  mysqli_query($conn, $consulta);

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
  <title>ParkioGO - Ingresar Cliente</title>
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
    <h2>Ingresar Datos del Cliente</h2>
    <form method="POST" action="procesar_datos_cliente.php">
      <div>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
      </div>
      <div>
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>
      </div>
      <div>
        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" required>
      </div>
      <div>
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required>
      </div>
      <div>
        <button type="submit" class="btn-agregar-cliente">Guardar Datos</button>
      </div>
    </form>
  </div>
</body>
</html>

