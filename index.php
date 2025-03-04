<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "rootroot";
$db = "concesionario";
$conn = mysqli_connect($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido al Concesionario</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
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
                    <?php if (isset($_SESSION["nombre"])) { ?>
                        <li class="nav-item">
                            <span class="nav-link text-white">Bienvenido, <strong><?= htmlspecialchars($_SESSION["nombre"]) ?></strong></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-danger text-white ms-3" href="cerrar_sesion.php">Cerrar Sesión</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>
                        <li class="nav-item"><a class="nav-link" href="registro.php">Registrarse</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mensajes de éxito o error después de una acción -->
    <div class="container mt-3">
        <?php if (isset($_GET['mensaje'])) { ?>
            <div class="alert alert-success text-center">
                <strong><?= htmlspecialchars($_GET['mensaje']) ?></strong>
                <br>
                <a href="mis_alquileres.php" class="btn btn-primary mt-2">Ver mis alquileres</a>
            </div>
        <?php } ?>
        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php } ?>
    </div>

    <!-- Contenido principal -->
    <div class="container text-center mt-5">
        <h1 class="fw-bold">Bienvenido al Concesionario</h1>
        <p class="lead">Elija una opción para continuar</p>

        <!-- Opciones de login y registro -->
        <?php if (!isset($_SESSION["nombre"])) { ?>
            <div class="mt-4">
                <a href="login.php" class="btn btn-primary btn-lg m-2">Iniciar Sesión</a>
                <a href="registro.php" class="btn btn-success btn-lg m-2">Registrarse</a>
            </div>
        <?php } ?>

        <!-- Opciones adicionales -->
        <div class="row mt-5">
            <div class="col-md-4">
                <div class="card bg-secondary text-light text-center">
                    <div class="card-body">
                        <h5 class="card-title">🚗 Coches</h5>
                        <p class="card-text">Consulta nuestra lista de coches disponibles.</p>
                        <a href="coches.php" class="btn btn-light">Ver Coches</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-secondary text-light text-center">
                    <div class="card-body">
                        <h5 class="card-title">👥 Usuarios</h5>
                        <p class="card-text">Gestiona los usuarios registrados.</p>
                        <a href="usuarios.php" class="btn btn-light">Ver Usuarios</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-secondary text-light text-center">
                    <div class="card-body">
                        <h5 class="card-title">📄 Alquileres</h5>
                        <p class="card-text">Gestiona los alquileres de coches.</p>
                        <a href="alquiler.php" class="btn btn-light">Ver Alquileres</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-5">
        <p class="text-center">&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
