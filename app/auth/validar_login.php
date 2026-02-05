<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Recibir datos del formulario
$usuario  = $_POST['usuario'];
$password = $_POST['password'];

// Consulta preparada para evitar inyección SQL
$sql = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si el usuario existe
if ($result->num_rows === 1) {
    $fila = $result->fetch_assoc();

    // Verificar contraseña cifrada
    if (password_verify($password, $fila['password'])) {
        $_SESSION['usuario'] = $fila['usuario'];
        header("Location: ../../public/dashboard.php");
        exit();
    }
}

// Si falla el login
header("Location: ../../public/index.php?error=1");
exit();
