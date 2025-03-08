<?php
$conexion = mysqli_connect("localhost", "root", "rootroot", "concesionario");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$coche = null;
if (isset($_GET["id"])) {
    $id_coche = intval($_GET["id"]); // Seguridad: convertir a número entero
    $stmt = $conexion->prepare("SELECT * FROM Coches WHERE id_coche = ?");
    $stmt->bind_param("i", $id_coche);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $coche = $resultado->fetch_assoc();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalles del Coche</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-dark text-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Concesionario</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="consultar_coches.php">Volver a la lista</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Iniciar sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Detalles del Coche</h2>

        <?php if ($coche) { ?>
            <div class="card mx-auto mt-4 p-4 bg-secondary text-light" style="max-width: 500px;">
                <img src="<?= htmlspecialchars($coche["foto"]) ?>" class="img-fluid rounded mb-3" alt="Foto del coche">
                <h5 class="text-center"><?= htmlspecialchars($coche["modelo"]) ?> - <?= htmlspecialchars($coche["marca"]) ?></h5>
                <p><strong>Color:</strong> <?= htmlspecialchars($coche["color"]) ?></p>
                <p><strong>Precio:</strong> <?= number_format($coche["precio"], 2) ?> €</p>

                <div class="alert alert-info text-center">Este coche está disponible para alquiler, pero necesitas estar logueado para alquilarlo.</div>
            </div>
        <?php } else { ?>
            <div class="alert alert-danger text-center mt-3">Coche no encontrado.</div>
        <?php } ?>

        <div class="text-center mt-4">
            <a href="consultar_coches.php" class="btn btn-secondary">Volver a la lista de coches</a>
            <a href="login.php" class="btn btn-primary">Iniciar sesión</a>
        </div>
    </div>

    <footer class="footer text-center mt-5">
        <p>&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
