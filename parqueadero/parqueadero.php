<?php
include('../database/db.php');

// Función para consultar los cubículos del parqueadero en la base de datos
function consultarCubiculos() {
    // Utilizamos la conexión existente
    global $conn;

    $consulta = "SELECT * FROM Cubiculo";
    $resultado = mysqli_query($conn, $consulta);
    $cubiculos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    return $cubiculos;
}

// Función para consultar los datos de un cubículo en la base de datos
function consultarCubiculo($idCubiculo) {
    // Utilizamos la conexión existente
    global $conn;

    // Verificar si el ID del cubículo está vacío
    if (empty($idCubiculo)) {
        return null;
    }

    $consulta = "SELECT * FROM Cubiculo WHERE idCubiculo = $idCubiculo";
    $resultado = mysqli_query($conn, $consulta);

    // Verificar si se encontraron resultados
    if (mysqli_num_rows($resultado) > 0) {
        $cubiculo = mysqli_fetch_assoc($resultado);
        return $cubiculo;
    } else {
        return null;
    }
}

// Función para actualizar los datos de un cubículo en la base de datos
function actualizarCubiculo($idCubiculo, $disponible) {
    // Utilizamos la conexión existente
    global $conn;

    $consulta = "UPDATE Cubiculo SET disponible = $disponible WHERE idCubiculo = $idCubiculo";
    mysqli_query($conn, $consulta);
}

// Obtener el ID del cubículo de la URL
$idCubiculo = $_GET['idCubiculo'] ?? '';

// Consultar los datos del cubículo en la base de datos
$cubiculo = consultarCubiculo($idCubiculo);

// Verificar si se ha enviado el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $idCubiculo = $_POST['idCubiculo'];
    $disponible = $_POST['disponible'];

    // Actualizar los datos del cubículo en la base de datos
    actualizarCubiculo($idCubiculo, $disponible);

    // Obtener los datos actualizados del cubículo
    $cubiculo = consultarCubiculo($idCubiculo);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Parqueadero</title>
    <link rel="stylesheet" type="text/css" href="../parqueadero/style.css"> 
    <link rel="Website Icon" type="png" href="../Recursos/LOGO-GRANDE.png"> <!--ICONO DE LA PAGINA-->
    <style>
        body{
            width: 100%;

            
        }
        .principal{
            width: 100%; 
        }
        .btn-ingresar_vehiculo{
            width: 120px;
            padding: 10px;
            background-color: white;
            display: block;
            text-align: center;
            margin-top: 10px;
            margin-bottom: 10px;
            color: #00aeff;;
            text-decoration: none;
            border-radius: 10px;
        }

        .btn-ingresar_vehiculo:hover{
            background-color: #00aeff;
            color: white;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 5px;
            width: 400px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

    .cuadro-verde {
        width: 120px;
        background-color: #66BB6A;
        padding: 1px;
        border-radius: 10px;
        color: white;
    }

    .cuadro-rojo {
        margin-Top: 5px;
        width: 120px;
        background-color: #EF5350;
        padding: 1px;
        border-radius: 10px;
        color: white;
    }
    </style>
</head>
<body>
    <div class="principal">
    <h1>Parqueadero</h1>

    <?php
    // Consultar los cubículos del parqueadero en la base de datos
    $cubiculos = consultarCubiculos();

    if ($cubiculos) {
        // Contadores de cubículos disponibles y ocupados
        $disponibles = 0;
        $ocupados = 0;

        foreach ($cubiculos as $cubiculo) {
            // Verificar si el cubículo está disponible u ocupado
            $estado = ($cubiculo['disponible'] == 1) ? 'Disponible' : 'No disponible';

            // Agregar una clase CSS adicional si el cubículo está ocupado
            $claseCss = ($cubiculo['disponible'] == 0) ? 'ocupado' : '';

            if ($cubiculo['disponible'] == 1) {
                $disponibles++;
            } else {
                $ocupados++;
            }
            ?>
            <div class="cubiculo <?php echo $claseCss; ?>">
                <h2>Cubículo ID: <?php echo $cubiculo['idCubiculo']; ?></h2>
                <p>Estado: <?php echo $estado; ?></p>

                <form method="POST">
                    <input type="hidden" name="idCubiculo" value="<?php echo $cubiculo['idCubiculo']; ?>"> 

                    <a class="btn-ingresar_vehiculo" href="#" onclick="openModal(<?php echo $cubiculo['idCubiculo']; ?>)">Ingresar Vehiculo</a>

                    <label for="disponible">Actualizar estado:</label>
                    <select name="disponible" id="disponible">
                        <option value="1" <?php if ($cubiculo['disponible'] == 1) echo "selected"; ?>>Disponible</option>
                        <option value="0" <?php if ($cubiculo['disponible'] == 0) echo "selected"; ?>>No disponible</option>
                    </select>
                    <br>
                    <button type="submit" name="actualizar">Actualizar</button> 
                </form>
            </div>
            <?php
        }

        // Mostrar el número de cubículos disponibles y ocupados
        ?>
        <div class="estado-cubiculos">
            <h1>Disponibilidad:</h1>
            <div class="cuadro-verde">
                <p>Disponibles: <?php echo $disponibles; ?></p>
            </div>
            <div class="cuadro-rojo">
                <p>Ocupados: <?php echo $ocupados; ?></p>
            </div>
        </div>
        <?php
    } else {
        echo "No se encontraron cubículos.";
    }
    ?>

    <!-- Vista flotante -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Ingresar Vehículo</h2>
            <form action="procesar_ingreso.php" method="POST">
                <!-- Campo oculto para almacenar el ID del cubículo -->
                <input type="hidden" name="idCubiculo" id="idCubiculo">

                <!-- Mostrar el ID del cubículo como texto -->
                <p>ID de Cubículo: <span id="cubiculoIdText"></span></p>

                <!-- Agregar campo de selección de vehículo asociado al cliente -->
                <label for="vehiculo">Vehículo:</label>
                <select name="vehiculo" id="vehiculo">
                    <?php foreach ($vehiculosAsociados as $vehiculo) { ?>
                        <option value="<?php echo $vehiculo['idVehiculo']; ?>">
                            <?php echo $vehiculo['marca'] . " " . $vehiculo['modelo'] . " - " . $vehiculo['placa']; ?>
                        </option>
                    <?php } ?>
                </select>


                <button type="submit" name="guardar">Guardar</button>
            </form>
        </div>
    </div>


</div>

</div>
<script>
// Función para abrir la vista flotante
function openModal(idCubiculo) {
    // Obtener el campo oculto y asignar el ID del cubículo
    var idCubiculoInput = document.getElementById("idCubiculo");
    idCubiculoInput.value = idCubiculo;

    // Obtener el elemento span para mostrar el ID del cubículo
    var cubiculoIdText = document.getElementById("cubiculoIdText");
    cubiculoIdText.textContent = idCubiculo;

    // Mostrar la vista flotante
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
}



    // Función para cerrar la vista flotante
    function closeModal() {
        // Ocultar la vista flotante
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    }
</script>
</body>
</html>

