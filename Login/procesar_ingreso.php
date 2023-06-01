<?php
include('../database/db.php');

// Obtener el ID del cubículo y del vehículo seleccionado
$idCubiculo = $_POST['idCubiculo'];
$idVehiculo = $_POST['idVehiculo'];

// Verificar si se ha seleccionado un vehículo
if (!empty($idVehiculo)) {
    // Actualizar el estado del cubículo a ocupado en la base de datos
    actualizarCubiculo($idCubiculo, 0);

    // Asociar el vehículo al cubículo en la base de datos
    asociarVehiculoCubiculo($idVehiculo, $idCubiculo);

    // Redireccionar a la página principal del parqueadero
    header("Location: parqueadero.php");
    exit();
} else {
    // Si no se seleccionó un vehículo, mostrar un mensaje de error
    echo "Error: No se ha seleccionado un vehículo.";
}
?>
