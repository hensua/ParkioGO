<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['idUsuario'])) {
  // Redirige al formulario de inicio de sesión
  header("Location: login.php");
  exit();
}

// Obtiene el ID del usuario almacenado en la sesión
$idUsuario = $_SESSION['idUsuario'];

// Realiza la conexión a la base de datos
include('../database/db.php');

// Consulta SQL para obtener el ID del cliente asociado al usuario
$consultaCliente = "SELECT idCliente FROM cliente WHERE idUsuario = '$idUsuario'";
$resultadoCliente = mysqli_query($conn, $consultaCliente);

if (!$resultadoCliente || mysqli_num_rows($resultadoCliente) === 0) {
  // Si el ID de cliente no existe, redirige o muestra un mensaje de error apropiado
  header("Location: error.php");
  exit();
}

// Obtiene el ID del cliente
$row = mysqli_fetch_assoc($resultadoCliente);
$idCliente = $row['idCliente'];

// Procesa los datos del formulario de vehículo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $marca = $_POST['marca'];
  $modelo = $_POST['modelo'];
  $placa = $_POST['placa'];
  $color = $_POST['color'];
  $tipoVehiculo = $_POST['tipo_vehiculo'];

  // Consulta SQL para insertar los datos del vehículo en la base de datos
  $consulta = "INSERT INTO vehiculo (idCliente, marca, modelo, placa, color, tipo_vehiculo) VALUES ('$idCliente', '$marca', '$modelo', '$placa', '$color', '$tipoVehiculo')";
  if (mysqli_query($conn, $consulta)) {
    // Redirige a la página de vista general si la inserción fue exitosa
    header("Location: vista_general.php");
    exit();
  } else {
    // Muestra un mensaje de error si la inserción falla
    echo "Error al insertar los datos del vehículo: " . mysqli_error($conn);
  }
}

// Cierra la conexión a la base de datos
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
  <title>ParkioGO-Ingresar Vehículo</title>
  <link rel="Website Icon" type="png" href="../Recursos/LOGO-GRANDE.png"> <!--ICONO DE LA PAGINA-->
  <link rel="stylesheet" type="text/css" href="../css/pDatosVehiculo.css">
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

    .container form input[type="text"] {
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
    <h2>Ingresar Datos del Vehículo</h2>
    <form method="POST" action="procesar_datos_vehiculo.php">
      <div>
        <label for="marca">Marca:</label>
        <input type="text" id="marca" name="marca" required>
      </div>
      <div>
        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo" required>
      </div>
      <div>
        <label for="placa">Placa:</label>
        <input type="text" id="placa" name="placa" required>
      </div>
      <div>
        <label for="color">Color:</label>
        <input type="text" id="color" name="color" required>
      </div>
      <div>
        <label for="tipo_vehiculo">Tipo de Vehículo:</label>
        <input type="text" id="tipo_vehiculo" name="tipo_vehiculo" required>
      </div>
      <div>
        <button type="submit" class="btn-agregar-vehiculo">Guardar Datos</button>
      </div>
    </form>
  </div>
</body>
</html>



