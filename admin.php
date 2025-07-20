<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'administrador') {
    header("Location: login.php");
    exit;
}
include 'conexion.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel de Administración</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?> (Administrador)</h1>

    <h2>Reservas</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Servicio</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estado</th>
        </tr>
        <?php
        $sql = "SELECT r.id, c.nombre AS cliente, s.nombre AS servicio, r.fecha, r.hora, r.estado
                FROM reservas r
                JOIN clientes c ON r.cliente_id = c.id
                JOIN servicios s ON r.servicio_id = s.id
                ORDER BY r.fecha DESC";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['cliente']}</td>
                    <td>{$row['servicio']}</td>
                    <td>{$row['fecha']}</td>
                    <td>{$row['hora']}</td>
                    <td>{$row['estado']}</td>
                  </tr>";
        }
        ?>
    </table>

    <h2>Servicios</h2>
    <ul>
        <?php
        $result = $conn->query("SELECT * FROM servicios");
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['nombre']} - \${$row['precio']}</li>";
        }
        ?>
    </ul>

    <h2>Empleados</h2>
    <ul>
        <?php
        $result = $conn->query("SELECT * FROM empleados");
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['nombre']} - {$row['correo']}</li>";
        }
        ?>
    </ul>

    <p><a href="logout.php">Cerrar sesión</a></p>
</body>
</html>
