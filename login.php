<?php
session_start();
include 'conexion.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $conn->real_escape_string($_POST['correo']);
    $contraseña = $conn->real_escape_string($_POST['contraseña']);

    // Buscar cliente
    $sql_cliente = "SELECT id, nombre FROM clientes WHERE correo='$correo' AND contraseña='$contraseña'";
    $resultado_cliente = $conn->query($sql_cliente);

    if ($resultado_cliente && $resultado_cliente->num_rows > 0) {
        $cliente = $resultado_cliente->fetch_assoc();
        $_SESSION['usuario_id'] = $cliente['id'];
        $_SESSION['rol'] = 'cliente';
        $_SESSION['nombre'] = $cliente['nombre'];
        header("Location: cliente_panel.php");
        exit();
    }

    // Buscar admin
    $sql_admin = "SELECT id, nombre FROM empleados WHERE correo='$correo' AND contraseña='$contraseña'";
    $resultado_admin = $conn->query($sql_admin);

    if ($resultado_admin && $resultado_admin->num_rows > 0) {
        $admin = $resultado_admin->fetch_assoc();
        $_SESSION['usuario_id'] = $admin['id'];
        $_SESSION['rol'] = 'administrador';
        $_SESSION['nombre'] = $admin['nombre'];

        // Limpia el buffer de salida para evitar que headers fallen
        if (ob_get_length()) ob_end_clean();

        header("Location: admin_panel.php");
        exit();
    }

    $error = "Correo o contraseña incorrectos.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Login - Peluquería Canina</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.2);
            width: 350px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        input[type=email], input[type=password] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        input[type=submit] {
            width: 100%;
            padding: 12px;
            background-color: #009688;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background-color: #00796b;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Iniciar Sesión</h2>
    <?php if ($error): ?>
        <div class="error"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>
    <form method="post" action="">
        <input type="email" name="correo" placeholder="Correo" required />
        <input type="password" name="contraseña" placeholder="Contraseña" required />
        <input type="submit" value="Ingresar" />
    </form>
</div>

</body>
</html>
