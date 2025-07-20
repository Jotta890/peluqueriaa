<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'cliente') {
    header("Location: login.php");
    exit;
}

include 'conexion.php';
include 'navbar.php';

$cliente_id = $_SESSION['usuario_id'];

// Obtener reservas del cliente
$sql = "SELECT r.id, s.nombre AS servicio, r.fecha, r.hora, r.estado 
        FROM reservas r
        JOIN servicios s ON r.servicio_id = s.id
        WHERE r.cliente_id = $cliente_id";

$resultado = $conn->query($sql);
?>

<h2>Mis Reservas</h2>

<?php if ($resultado && $resultado->num_rows > 0): ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Servicio</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estado</th>
        </tr>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo $fila['id']; ?></td>
                <td><?php echo $fila['servicio']; ?></td>
                <td><?php echo $fila['fecha']; ?></td>
                <td><?php echo $fila['hora']; ?></td>
                <td><?php echo $fila['estado']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No tienes reservas registradas aún.</p>
<?php endif; ?>
