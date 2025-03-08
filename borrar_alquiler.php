<?php
$conexion = mysqli_connect("localhost", "root", "rootroot", "concesionario");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$mensaje = "";

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $sql = "DELETE FROM Alquileres WHERE id_alquiler = $id";
    
    if (mysqli_query($conexion, $sql)) {
        $mensaje = "<div class='alert alert-success text-center'>Alquiler eliminado correctamente. <a href='alquiler_listar.php' class='alert-link'>Ver lista de alquileres</a></div>";
    } else {
        $mensaje = "<div class='alert alert-danger text-center'>Error al eliminar el alquiler.</div>";
    }
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eliminar Alquiler</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php">Concesionario</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="alquiler_listar.php">Ver Alquileres</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Eliminar Alquiler</h2>

        <?php echo $mensaje; ?>

        <div class="text-center mt-4">
            <a href="alquiler_listar.php" class="btn btn-primary">Volver a la lista de alquileres</a>
        </div>
    </div>
    <footer class="footer mt-5">
        <p>&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
