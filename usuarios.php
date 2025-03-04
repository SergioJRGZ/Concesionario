<?php
session_start();

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== "administrador") {
    // Redirigir a index.php si no es administrador
    header("Location: index.php?mensaje=Acceso denegado.");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Usuarios</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-dark text-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Concesionario</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Volver al inicio</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container text-center mt-5">
        <h2 class="fw-bold">Gestión de Usuarios</h2>
        <p class="lead">Seleccione una opción para administrar los usuarios.</p>

        <!-- Opciones de gestión -->
        <div class="row mt-5">
            <div class="col-md-4">
                <div class="card bg-secondary text-light text-center">
                    <div class="card-body">
                        <h5 class="card-title">➕ Añadir Usuario</h5>
                        <p class="card-text">Registra un nuevo usuario en el sistema.</p>
                        <a href="añadir_usuario.php" class="btn btn-light">Añadir Usuario</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-secondary text-light text-center">
                    <div class="card-body">
                        <h5 class="card-title">📋 Listar Usuarios</h5>
                        <p class="card-text">Consulta todos los usuarios registrados.</p>
                        <a href="listar_usuarios.php" class="btn btn-light">Ver Usuarios</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-secondary text-light text-center">
                    <div class="card-body">
                        <h5 class="card-title">🔍 Buscar Usuario</h5>
                        <p class="card-text">Busca un usuario específico en el sistema.</p>
                        <a href="buscar_usuario.php" class="btn btn-light">Buscar Usuario</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de regreso -->
        <div class="text-center mt-5">
            <a href="index.php" class="btn btn-primary">⬅ Volver al inicio</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer text-center mt-5">
        <p>&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
