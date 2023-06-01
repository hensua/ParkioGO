<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ya ha iniciado sesión, en caso contrario muestra el formulario de inicio de sesión
if (isset($_SESSION['idUsuario'])) {
  header("Location: vista_general.php");
  exit();
}

// Verifica si se ha enviado el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Realiza la validación de los campos del formulario
  $correoElectronico = $_POST['correoElectronico'];
  $contrasena = $_POST['contrasena'];

  // Realiza la conexión a la base de datos
  include('../database/db.php');

  // Consulta SQL para verificar las credenciales del usuario
  $consulta = "SELECT * FROM Usuario WHERE correoElectronico = '$correoElectronico' AND contrasena = '$contrasena'";
  $resultado = mysqli_query($conn, $consulta);
  $usuario = mysqli_fetch_assoc($resultado);

  // Cierra la conexión a la base de datos
  mysqli_close($conn);

  // Verifica si se encontró un usuario con las credenciales proporcionadas
  if ($usuario) {
    // Almacena los datos de usuario en la sesión
    $_SESSION['idUsuario'] = $usuario['idUsuario'];
    $_SESSION['nombreUsuario'] = $usuario['nombreUsuario'];

    // Redirige a la página de vista general
    header("Location: vista_general.php");
    exit();
  } else {
    $mensajeError = "Credenciales incorrectas. Por favor, inténtalo nuevamente.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>ParkioGO - Login</title>
  <link rel="stylesheet" type="text/css" href="../css/login.css">
  <link rel="Website Icon" type="png" href="../Recursos/LOGO-GRANDE.png"> <!--ICONO DE LA PAGINA-->
  <style>
    /* Estilos para el formulario de login */
    .container {
      width: 400px;
      margin: 0 auto;
      padding: 20px;
      background-color: #f4f4f4;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    }

    .container h2 {
      margin-top: 0;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
    }

    .form-group input[type="email"],
    .form-group input[type="password"] {
      width: 100%;
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .form-group button {
      background-color: #4caf50;
      color: #fff;
      border: none;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 5px;
    }

    .form-group button:hover {
      background-color: #45a049;
    }

    .form-group p {
      color: #f00;
      margin: 0;
    }

    .form-group a {
      display: block;
      text-align: center;
      margin-top: 10px;
      color: #0000ff;
      text-decoration: none;
    }

    .form-group .btn-volver {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 5px;
    }

    .form-group .btn-volver:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
<div class="form-group">
      <a href="../Inicio/index.php" class="btn-volver">Volver al inicio</a>
    </div>
  <div class="container">
    <h2>Login</h2>
    <form method="POST" action="">
      <div class="form-group">
        <label for="correoElectronico">Correo Electrónico:</label>
        <input type="email" name="correoElectronico" required>
      </div>
      <div class="form-group">
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>
      </div>
      <div class="form-group">
        <button type="submit">Iniciar sesión</button>
      </div>
      <?php if (isset($mensajeError)) : ?>
        <p><?php echo $mensajeError; ?></p>
      <?php endif; ?>
    </form>
    <div class="form-group">
      <a href="registro.php">¿No tienes una cuenta? Regístrate aquí</a>
    </div>
    
  </div>
</body>
</html>
