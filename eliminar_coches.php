<?php
$conexion = mysqli_connect("localhost", "root", "rootroot", "concesionario");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$mensaje = "";

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]); // Convertir ID a número entero para mayor seguridad

    // Verificar si el coche existe antes de eliminarlo
    $sql_check = "SELECT * FROM Coches WHERE id_coche = ?";
    $stmt_check = $conexion->prepare($sql_check);
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $resultado = $stmt_check->get_result();

    if ($resultado->num_rows > 0) {
        // Eliminar el coche con consulta preparada
        $sql = "DELETE FROM Coches WHERE id_coche = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $mensaje = "<div class='alert alert-success text-center'>Coche eliminado correctamente. <a href='listar_coches.php' class='alert-link'>Volver</a></div>";
        } else {
            $mensaje = "<div class='alert alert-danger text-center'>Error al eliminar el coche.</div>";
        }

        $stmt->close();
    } else {
        $mensaje = "<div class='alert alert-warning text-center'>El coche no existe o ya ha sido eliminado.</div>";
    }

    $stmt_check->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eliminar Coche</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <!-- Navbar -->
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

    <!-- Contenido principal -->
    <div class="container mt-5">
        <h2 class="text-center">Eliminar Coche</h2>

        <?= $mensaje; ?>

        <div class="text-center mt-4">
            <a href="listar_coches.php" class="btn btn-primary">Volver a la lista de coches</a>
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
