<?php
session_start();
session_destroy();

// Regresar al login
header("Location: ../../public/index.php");
exit();
