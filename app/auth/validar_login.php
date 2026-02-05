<?php
/*
    1️⃣ Valida usuario y contraseña
    2️⃣ Si son correctos, genera código 2FA
    3️⃣ Envía el código por correo
    4️⃣ Redirige a verificación
*/

session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../mail/enviar_codigo.php';

$usuario  = $_POST['usuario'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $fila = $result->fetch_assoc();

    if (password_verify($password, $fila['password'])) {

        // Generar código de 6 dígitos
        $codigo = random_int(100000, 999999);

        // Guardar datos temporales en sesión
        $_SESSION['2fa_codigo']  = $codigo;
        $_SESSION['2fa_expira']  = time() + 300; // 5 minutos
        $_SESSION['2fa_usuario'] = $fila['usuario'];
        $_SESSION['2fa_correo']  = $fila['correo'];

        // Enviar correo
        enviarCodigo($fila['correo'], $codigo);

        header("Location: ../../public/verificar_codigo.php");
        exit();
    }
}

// Error de login
header("Location: ../../public/index.php?error=1");
exit();
