<?php
session_start();
include 'conexion.php';

// Verificar que el usuario esté logueado y sea cliente
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: login.php");
    exit;
}

// Cargar servicios para el select
$sql = "SELECT id, nombre FROM servicios";
$resultado = $conn->query($sql);

$error = "";
$mensaje = "";

// Procesar formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente_id = $_SESSION['usuario_id'];
    $servicio_id = $_POST['servicio_id'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    // Validar campos (simple ejemplo)
    if (empty($servicio_id) || empty($fecha) || empty($hora)) {
        $error = "Por favor completa todos los campos.";
    } else {
        // Insertar la reserva con estado "Pendiente"
        $stmt = $conn->prepare("INSERT INTO reservas (cliente_id, servicio_id, fecha, hora, estado) VALUES (?, ?, ?, ?, 'Pendiente')");
        $stmt->bind_param("iiss", $cliente_id, $servicio_id, $fecha, $hora);

        if ($stmt->execute()) {
            $mensaje = "Reserva realizada con éxito.";
        } else {
            $error = "Error al guardar la reserva: " . $conn->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Reservar Servicio - Peluquería Canina</title>
</head>
<body>
    <h2>Realizar una reserva</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($mensaje): ?>
        <p style="color:green;"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <form method="post" action="reservar.php">
        <label for="servicio">Servicio:</label><br />
        <select id="servicio" name="servicio_id" required>
            <option value="">-- Seleccione un servicio --</option>
            <?php
            if ($resultado && $resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo '<option value="' . $fila['id'] . '">' . htmlspecialchars($fila['nombre']) . '</option>';
                }
            } else {
                echo '<option value="">No hay servicios disponibles</option>';
            }
            ?>
        </select><br /><br />

        <label for="fecha">Fecha:</label><br />
        <input type="date" id="fecha" name="fecha" required /><br /><br />

        <label for="hora">Hora:</label><br />
        <input type="time" id="hora" name="hora" required /><br /><br />

        <input type="submit" value="Reservar" />
    </form>
</body>
</html>

