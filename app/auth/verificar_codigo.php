<?php
/*
    Página donde el usuario escribe el código 2FA
*/

session_start();

// Si no hay código, no debería estar aquí
if (!isset($_SESSION['2fa_codigo'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificación</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="login-box">
    <h2>Verificación en dos pasos</h2>
    <p>Ingresa el código que enviamos a tu correo</p>

    <form action="../app/auth/validar_codigo.php" method="POST">
        <input type="number" name="codigo" placeholder="Código de 6 dígitos" required>
        <button type="submit">Verificar</button>
    </form>

    <?php if (isset($_GET['error'])): ?>
        <p class="error">Código incorrecto o expirado</p>
    <?php endif; ?>
</div>

</body>
</html>
