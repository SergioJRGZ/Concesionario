<?php
$conexion = mysqli_connect("localhost", "root", "rootroot", "concesionario");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$coche = null;

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]); // Seguridad: convertir a número entero
    $stmt = $conexion->prepare("SELECT * FROM Coches WHERE id_coche = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $coche = $resultado->fetch_assoc();
    $stmt->close();

    if (!$coche) {
        die("Coche no encontrado.");
    }
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["id"]);
    $modelo = htmlspecialchars($_POST["modelo"]);
    $marca = htmlspecialchars($_POST["marca"]);
    $color = htmlspecialchars($_POST["color"]);
    $precio = floatval($_POST["precio"]);

    $stmt = $conexion->prepare("UPDATE Coches SET modelo=?, marca=?, color=?, precio=? WHERE id_coche=?");
    $stmt->bind_param("sssdi", $modelo, $marca, $color, $precio, $id);

    if ($stmt->execute()) {
        $mensaje = "<div class='alert alert-success text-center'>Coche actualizado correctamente. <a href='listar_coches.php' class='alert-link'>Volver</a></div>";
    } else {
        $mensaje = "<div class='alert alert-danger text-center'>Error al actualizar el coche.</div>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Coche</title>

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
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <h2 class="text-center">Editar Coche</h2>

        <?= $mensaje; ?>

        <div class="card p-4 mx-auto mt-4" style="max-width: 500px;">
            <form method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars($coche['id_coche']) ?>">

                <div class="mb-3">
                    <label class="form-label">Modelo:</label>
                    <input type="text" name="modelo" class="form-control" value="<?= htmlspecialchars($coche['modelo']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Marca:</label>
                    <input type="text" name="marca" class="form-control" value="<?= htmlspecialchars($coche['marca']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Color:</label>
                    <input type="text" name="color" class="form-control" value="<?= htmlspecialchars($coche['color']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Precio:</label>
                    <input type="number" name="precio" class="form-control" step="0.01" value="<?= htmlspecialchars($coche['precio']) ?>" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Actualizar Coche</button>
            </form>
        </div>

        <div class="text-center mt-4">
            <a href="listar_coches.php" class="btn btn-secondary">Cancelar</a>
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
