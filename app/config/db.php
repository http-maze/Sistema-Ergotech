<?php
/*
    Archivo de conexión a la base de datos
    Aquí van datos sensibles, por eso NO está en public
*/

$host = "localhost";
$user = "root";
$pass = "";
$db   = "mi_base_datos";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
