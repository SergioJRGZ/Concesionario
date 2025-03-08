<?php
$conexion = mysqli_connect("localhost", "root", "rootroot", "concesionario");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$mensaje = "";
if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $sql = "DELETE FROM Coches WHERE id_coche = $id";
    if (mysqli_query($conexion, $sql) && mysqli_affected_rows($conexion) > 0) {
        $mensaje = "<div class='alert alert-success text-center'>Coche eliminado correctamente. <a href='listar_coches.php' class='alert-link'>Volver</a></div>";
    } else {
        $mensaje = "<div class='alert alert-warning text-center'>El coche no existe o ya ha sido eliminado.</div>";
    }
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eliminar Coche</title>

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
                    <li class="nav-item"><a class="nav-link" href="listar_coches.php">Ver Coches</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Eliminar Coche</h2>

        <?= $mensaje; ?>

        <div class="text-center mt-4">
            <a href="listar_coches.php" class="btn btn-primary">Volver a la lista de coches</a>
        </div>
    </div>

    <footer class="footer mt-5">
        <p class="text-center">&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
