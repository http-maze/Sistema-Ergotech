<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Recibir datos del formulario
$nombre = trim($_POST['nombre']);
$email = trim($_POST['email']);
$telefono = trim($_POST['telefono']);
$cargo = trim($_POST['cargo']);
$empresa = trim($_POST['empresa']);
$sector = trim($_POST['sector']);
$num_empleados = $_POST['num_empleados'];
$pais = trim($_POST['pais']);
$ciudad = trim($_POST['ciudad']);
$usuario = trim($_POST['usuario']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$acepto_terminos = isset($_POST['acepto_terminos']) ? 1 : 0;

// Validaciones básicas
if (empty($nombre) || empty($email) || empty($usuario) || empty($password)) {
    header("Location: ../../public/registro.php?error=1");
    exit();
}

// Verificar contraseñas
if ($password !== $confirm_password) {
    header("Location: ../../public/registro.php?error=5");
    exit();
}

// Verificar términos
if (!$acepto_terminos) {
    header("Location: ../../public/registro.php?error=3");
    exit();
}

// Verificar si el usuario o email ya existen
$sql_check = "SELECT id FROM usuarios WHERE usuario = ? OR correo = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ss", $usuario, $email);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    header("Location: ../../public/registro.php?error=2");
    exit();
}

// Cifrar contraseña
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Obtener IP del usuario
$ip_aceptacion = $_SERVER['REMOTE_ADDR'];

// Insertar nuevo cliente
$sql_insert = "INSERT INTO usuarios (
    nombre_completo,
    usuario,
    correo,
    password,
    empresa,
    telefono,
    cargo,
    sector,
    num_empleados,
    pais,
    ciudad,
    acepto_terminos,
    fecha_aceptacion,
    version_terminos,
    ip_aceptacion,
    tipo_usuario,
    activo,
    fecha_registro
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 1, ?, 'cliente', 1, NOW())";

$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param(
    "sssssssssssss",
    $nombre,
    $usuario,
    $email,
    $password_hash,
    $empresa,
    $telefono,
    $cargo,
    $sector,
    $num_empleados,
    $pais,
    $ciudad,
    $acepto_terminos,
    $ip_aceptacion
);

if ($stmt_insert->execute()) {
    // Enviar email de confirmación (opcional)
    // enviarEmailConfirmacion($email, $nombre);
    
    header("Location: ../../public/registro.php?success=1");
    exit();
} else {
    header("Location: ../../public/registro.php?error=4");
    exit();
}
?>
4. Modificar validar_login.php para verificar términos:
php
<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../mail/enviar_codigo.php';

$usuario = $_POST['usuario'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $fila = $result->fetch_assoc();

    if (password_verify($password, $fila['password'])) {
        
        // VERIFICAR SI ACEPTÓ TÉRMINOS
        if (!$fila['acepto_terminos']) {
            // Redirigir a página para aceptar términos
            $_SESSION['usuario_pendiente'] = $fila['usuario'];
            $_SESSION['usuario_id'] = $fila['id'];
            header("Location: ../../public/aceptar_terminos.php");
            exit();
        }
        
        // VERIFICAR SI ESTÁ ACTIVO
        if (!$fila['activo']) {
            header("Location: ../../public/index.php?error=3"); // Cuenta inactiva
            exit();
        }

        // Generar código de 6 dígitos para 2FA
        $codigo = random_int(100000, 999999);

        // Guardar datos temporales en sesión
        $_SESSION['2fa_codigo'] = $codigo;
        $_SESSION['2fa_expira'] = time() + 300; // 5 minutos
        $_SESSION['2fa_usuario'] = $fila['usuario'];
        $_SESSION['2fa_correo'] = $fila['correo'];
        $_SESSION['usuario_id'] = $fila['id'];

        // Enviar correo
        enviarCodigo($fila['correo'], $codigo);

        header("Location: ../../public/verificar_codigo.php");
        exit();
    }
}

// Error de login
header("Location: ../../public/index.php?error=1");
exit();
?>
