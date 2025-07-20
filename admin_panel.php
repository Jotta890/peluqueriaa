<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: login.php");
    exit;
}

// Consultas para mostrar datos
$reservas = $conn->query("
    SELECT r.id, c.nombre AS cliente, s.nombre AS servicio, r.fecha, r.hora, r.estado
    FROM reservas r
    JOIN clientes c ON r.cliente_id = c.id
    JOIN servicios s ON r.servicio_id = s.id
    ORDER BY r.fecha DESC, r.hora DESC
");

$servicios = $conn->query("SELECT * FROM servicios ORDER BY nombre");

$empleados = $conn->query("SELECT * FROM empleados ORDER BY nombre");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Panel Administrador - Peluquería Canina</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #009688; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 30px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        a.logout { float: right; background: #f44336; color: white; padding: 8px 12px; text-decoration: none; border-radius: 4px; }
        a.logout:hover { background: #d32f2f; }
    </style>
</head>
<body>

<h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?> (Administrador)</h1>
<a href="logout.php" class="logout">Cerrar sesión</a>

<h2>Reservas</h2>
<?php
if ($reservas && $reservas->num_rows > 0) {
    echo '<table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Servicio</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>';
    while ($fila = $reservas->fetch_assoc()) {
        echo '<tr>
            <td>' . $fila['id'] . '</td>
            <td>' . htmlspecialchars($fila['cliente']) . '</td>
            <td>' . htmlspecialchars($fila['servicio']) . '</td>
            <td>' . $fila['fecha'] . '</td>
            <td>' . $fila['hora'] . '</td>
            <td>' . htmlspecialchars($fila['estado']) . '</td>
        </tr>';
    }
    echo '</tbody></table>';
} else {
    echo '<p>No hay reservas registradas.</p>';
}
?>

<h2>Servicios</h2>
<?php
if ($servicios && $servicios->num_rows > 0) {
    echo '<table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>';
    while ($serv = $servicios->fetch_assoc()) {
        echo '<tr>
            <td>' . $serv['id'] . '</td>
            <td>' . htmlspecialchars($serv['nombre']) . '</td>
            <td>' . htmlspecialchars($serv['descripción']) . '</td>
            <td>$' . number_format($serv['precio'], 2) . '</td>
        </tr>';
    }
    echo '</tbody></table>';
} else {
    echo '<p>No hay servicios registrados.</p>';
}
?>

<h2>Empleados</h2>
<?php
if ($empleados && $empleados->num_rows > 0) {
    echo '<table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>';
    while ($emp = $empleados->fetch_assoc()) {
        echo '<tr>
            <td>' . $emp['id'] . '</td>
            <td>' . htmlspecialchars($emp['nombre']) . '</td>
            <td>' . htmlspecialchars($emp['correo']) . '</td>
        </tr>';
    }
    echo '</tbody></table>';
} else {
    echo '<p>No hay empleados registrados.</p>';
}
?>

</body>
</html>
