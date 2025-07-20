<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'cliente') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel del Cliente</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>

    <a href="reservar.php"><button>Reservar</button></a>
    <a href="mis_reservas.php"><button>Mis Reservas</button></a>
    <a href="logout.php"><button>Cerrar sesión</button></a>
</body>
</html>