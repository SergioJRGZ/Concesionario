<?php
session_start();
if (!isset($_SESSION["id_usuario"]) || $_SESSION["tipo"] != "comprador") {
    header("Location: login.php");
    exit();
}

$conexion = mysqli_connect("localhost", "root", "rootroot", "concesionario");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$coche = null;
$mensaje = "";

if (isset($_GET["id"])) {
    $id_coche = intval($_GET["id"]);
    $stmt = $conexion->prepare("SELECT * FROM Coches WHERE id_coche = ?");
    $stmt->bind_param("i", $id_coche);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $coche = $resultado->fetch_assoc();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $coche) {
    if ($coche["alquilado"] == 0) {
        $id_usuario = $_SESSION["id_usuario"];
        $fecha_prestado = date("Y-m-d H:i:s");

        $stmt_alquiler = $conexion->prepare("INSERT INTO Alquileres (id_usuario, id_coche, prestado) VALUES (?, ?, ?)");
        $stmt_alquiler->bind_param("iis", $id_usuario, $id_coche, $fecha_prestado);

        if ($stmt_alquiler->execute()) {
            $stmt_actualizar = $conexion->prepare("UPDATE Coches SET alquilado = 1 WHERE id_coche = ?");
            $stmt_actualizar->bind_param("i", $id_coche);
            $stmt_actualizar->execute();
            $stmt_actualizar->close();

            $mensaje = "<div class='alert alert-success text-center'>¡Coche alquilado con éxito!</div>";
        } else {
            $mensaje = "<div class='alert alert-danger text-center'>Error al alquilar el coche.</div>";
        }

        $stmt_alquiler->close();
    } else {
        $mensaje = "<div class='alert alert-warning text-center'>Este coche ya ha sido alquilado.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalles del Coche</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Concesionario</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="buscar_coches_compradores.php">Volver a la búsqueda</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <h2 class="text-center">Detalles del Coche</h2>

        <?= $mensaje; ?>

        <?php if ($coche) { ?>
            <div class="card mx-auto mt-4 p-4" style="max-width: 500px;">
                <img src="<?= htmlspecialchars($coche["foto"]) ?>" class="img-fluid rounded mb-3" alt="Foto del coche">
                <h5 class="text-center"><?= htmlspecialchars($coche["modelo"]) ?> - <?= htmlspecialchars($coche["marca"]) ?></h5>
                <p><strong>Color:</strong> <?= htmlspecialchars($coche["color"]) ?></p>
                <p><strong>Precio:</strong> <?= number_format($coche["precio"], 2) ?> €</p>

                <?php if ($coche["alquilado"] == 0) { ?>
                    <form method="post">
                        <button type="submit" class="btn btn-primary w-100">Alquilar Coche</button>
                    </form>
                <?php } else { ?>
                    <div class="alert alert-warning text-center mt-3">Este coche ya ha sido alquilado.</div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="alert alert-danger text-center mt-3">Coche no encontrado.</div>
        <?php } ?>

        <!-- Botón de regreso -->
        <div class="text-center mt-4">
            <a href="buscar_coches_compradores.php" class="btn btn-secondary">Volver a la búsqueda</a>
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
