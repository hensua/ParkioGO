<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión, en caso contrario redirige al formulario de inicio de sesión
if (!isset($_SESSION['idUsuario'])) {
    header("Location: login.php");
    exit();
}

// Función para verificar si el usuario tiene datos de cliente asociados
function tieneDatosCliente($idUsuario) {
    // Realiza la conexión a la base de datos
    include('../database/db.php');

    // Verifica si el usuario ya tiene datos de cliente registrados
    $consultaExistencia = "SELECT idCliente FROM cliente WHERE idUsuario = '$idUsuario'";
    $resultadoExistencia = mysqli_query($conn, $consultaExistencia);
    $datosCliente = mysqli_fetch_assoc($resultadoExistencia);

    // Cierra la conexión a la base de datos
    mysqli_close($conn);

    return $datosCliente ? true : false;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>ParkioGO - Vista General</title>
    <link rel="stylesheet" type="text/css" href="../css/vista.css">
    <link rel="stylesheet" type="text/css" href="../parqueadero/style.css"> 
    <link rel="Website Icon" type="png" href="../Recursos/LOGO-GRANDE.png"> <!--ICONO DE LA PAGINA-->

</head>
<body>
<div class="header">
    <h1>Vista General</h1>
    
        <!-- Menú desplegable -->
    <div class="dropdown">
        <button>Bienvenido! <b><?php echo $_SESSION['nombreUsuario']; ?></b></button>
        <div class="dropdown-content">
            <!-- Botón para agregar vehículo -->
            <a href="procesar_datos_vehiculo.php">Agregar Vehiculo</a>

            <!-- Botón para agregar o editar los datos del cliente -->
            <?php if (tieneDatosCliente($_SESSION['idUsuario'])) { ?>
                <a href="editar_datos_cliente.php">Editar Datos del Cliente</a>
            <?php } else { ?>
                <a href="procesar_datos_cliente.php">Agregar Datos del Cliente</a>
            <?php } ?>

            <a href="cerrar_sesion.php">Cerrar Sesión</a>
        </div>
    </div>
</div>

<!-- <div class="container">
    Contenido de la página
    <h2>Contenido de la vista general</h2>
     Agrega aquí el contenido adicional de la vista general 
    <p>Esta es la página de vista general.</p>
    <p>Aquí puedes mostrar información adicional para el usuario.</p>
</div> -->

<div>
    <?php
    // Incluye el archivo parqueadero.php
    include('../parqueadero/parqueadero.php');
    ?>
</div>

</body>
</html>

