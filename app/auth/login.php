<?php
// Iniciar sesión
session_start();

// Si ya hay sesión, redirigir al dashboard
if (isset($_SESSION['usuario'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="login-box">
    <h2>Iniciar sesión</h2>

    <form action="../app/auth/validar_login.php" method="POST">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Entrar</button>
    </form>

    <?php if (isset($_GET['error'])): ?>
        <p class="error">Usuario o contraseña incorrectos</p>
    <?php endif; ?>
</div>

</body>
</html>
