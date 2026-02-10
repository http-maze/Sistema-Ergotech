<?php
session_start();

/*
    Este archivo protege páginas
    Si no hay sesión, regresa al login
*/

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
