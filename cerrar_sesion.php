<?php
session_start();
session_unset(); // Eliminar todas las variables de sesión
session_destroy(); // Destruir la sesión

header("Location: index.php");
exit();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cerrar Sesión</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-dark text-light">

    <div class="text-center">
        <h2 class="mb-3">Sesión cerrada</h2>
        <p>Redirigiéndote a la página de inicio de sesión...</p>
        <div class="spinner-border text-warning" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
