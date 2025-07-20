<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $pass = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO clientes (nombre, correo, contraseña) VALUES ('$nombre', '$correo', '$pass')";

    if ($conn->query($sql) === TRUE) {
        echo "Registro exitoso. <a href='login.php'>Inicia sesión aquí</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<form method="post">
    <h2>Registro de Cliente</h2>
    Nombre: <input type="text" name="nombre" required><br>
    Correo: <input type="email" name="correo" required><br>
    Contraseña: <input type="password" name="contraseña" required><br>
    <input type="submit" value="Registrarse">
</form>
