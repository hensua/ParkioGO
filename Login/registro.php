<!DOCTYPE html>
<html>

<head>
  <title>ParkioGO - Registro</title>
  <link rel="stylesheet" type="text/css" href="../css/registro.css">
  <link rel="Website Icon" type="png" href="../Recursos/LOGO-GRANDE.png"> <!--ICONO DE LA PAGINA-->
</head>

<body>
  <div class="container">
    <h2>Registro</h2>
    <form method="POST" action="registro.php">
      <div class="form-group">
        <label for="nombreUsuario">Nombre de usuario:</label>
        <input type="text" name="nombreUsuario" required>
      </div>
      <div class="form-group">
        <label for="correoElectronico">Correo electrónico:</label>
        <input type="email" name="correoElectronico" required>
      </div>
      <div class="form-group">
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>
      </div>
      <button type="submit" class="btn">Registrarse</button>
    </form>
  </div>

  <?php
  include('../database/db.php');

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreUsuario = $_POST['nombreUsuario'];
    $correoElectronico = $_POST['correoElectronico'];
    $contrasena = $_POST['contrasena'];

    // Valor del rol para ser cliente
    $rolCliente = 2; // Reemplaza con el valor correcto según tu base de datos

    $consulta = "INSERT INTO Usuario (nombreUsuario, correoElectronico, contrasena, idRol) VALUES ('$nombreUsuario', '$correoElectronico', '$contrasena', $rolCliente)";
    mysqli_query($conn, $consulta);

    // Redireccionar al usuario después de registrarse
    header("Location: login.php");
    exit();
  }
  ?>

</body>

</html>


