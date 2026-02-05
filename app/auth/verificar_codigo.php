<?php
session_start();

if (!isset($_SESSION['2fa_codigo'])) {
    header("Location: index.php");
    exit();
}
?>

<form action="../app/auth/validar_codigo.php" method="POST">
    <h2>Verificación en dos pasos</h2>
    <p>Ingresa el código que enviamos a tu correo</p>

    <input type="number" name="codigo" required>
    <button type="submit">Verificar</button>
</form>
