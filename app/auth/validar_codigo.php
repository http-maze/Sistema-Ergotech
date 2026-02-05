<?php
session_start();

if (!isset($_SESSION['2fa_codigo'])) {
    header("Location: ../../public/index.php");
    exit();
}

$codigoIngresado = $_POST['codigo'];

if (
    $codigoIngresado == $_SESSION['2fa_codigo'] &&
    time() <= $_SESSION['2fa_expira']
) {
    // Login completo
    $_SESSION['usuario'] = $_SESSION['2fa_usuario'];

    // Limpiar datos 2FA
    unset($_SESSION['2fa_codigo']);
    unset($_SESSION['2fa_expira']);
    unset($_SESSION['2fa_usuario']);
    unset($_SESSION['2fa_correo']);

    header("Location: ../../public/dashboard.php");
    exit();
}

header("Location: ../../public/verificar_codigo.php?error=1");
exit();
