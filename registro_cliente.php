<!-- registro_cliente.php -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Cliente</title>
</head>
<body>
  <h2>Registro de Cliente</h2>
  <form action="registro_cliente.php" method="post">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" required><br><br>

    <label>Correo:</label><br>
    <input type="email" name="correo" required><br><br>

    <label>Contraseña:</label><br>
    <input type="password" name="contrasena" required><br><br>

    <input type="submit" value="Registrarse">
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "conexion.php"; // incluye tu conexión

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Verificar si el correo ya está registrado
    $verificar = $conn->prepare("SELECT * FROM clientes WHERE correo = ?");
    $verificar->bind_param("s", $correo);
    $verificar->execute();
    $resultado = $verificar->get_result();

    if ($resultado->num_rows > 0) {
      echo "<p style='color:red;'>Este correo ya está registrado.</p>";
    } else {
      // Insertar nuevo cliente
      $stmt = $conn->prepare("INSERT INTO clientes (nombre, correo, contraseña) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $nombre, $correo, $contrasena);

      if ($stmt->execute()) {
        echo "<p style='color:green;'>¡Registro exitoso! Ya puedes <a href='login.php'>iniciar sesión</a>.</p>";
      } else {
        echo "<p style='color:red;'>Error al registrar.</p>";
      }

      $stmt->close();
    }

    $conn->close();
  }
  ?>
</body>
</html>
