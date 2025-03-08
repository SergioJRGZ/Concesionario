<?php
session_start();
if (!isset($_SESSION["id_usuario"]) || $_SESSION["tipo"] != "comprador") {
    header("Location: login.php");
    exit();
}
$conexion = mysqli_connect("localhost", "root", "rootroot", "concesionario");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
$coche = null;
$mensaje = "";
if (isset($_GET["id"])) {
    $id_coche = intval($_GET["id"]);
    $sql = "SELECT * FROM Coches WHERE id_coche = $id_coche";
    $resultado = mysqli_query($conexion, $sql);
    $coche = mysqli_fetch_assoc($resultado);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($coche["id_coche"])) {
    if ($coche["alquilado"] == 0) {
        $id_usuario = $_SESSION["id_usuario"];
        $fecha_prestado = date("Y-m-d H:i:s");
        
        $sql_alquiler = "INSERT INTO Alquileres (id_usuario, id_coche, prestado) VALUES ($id_usuario, $id_coche, '$fecha_prestado')";
        
        if (mysqli_query($conexion, $sql_alquiler)) {
            $sql_actualizar = "UPDATE Coches SET alquilado = 1 WHERE id_coche = $id_coche";
            mysqli_query($conexion, $sql_actualizar);
            
            $mensaje = "<div class='alert alert-success text-center'>¡Coche alquilado con éxito!</div>";
        } else {
            $mensaje = "<div class='alert alert-danger text-center'>Error al alquilar el coche.</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-warning text-center'>Este coche ya ha sido alquilado.</div>";
    }
}
mysqli_close($conexion);
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
<body>

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

        <div class="text-center mt-4">
            <a href="buscar_coches_compradores.php" class="btn btn-secondary">Volver a la búsqueda</a>
        </div>
    </div>

    <footer class="footer text-center mt-5">
        <p>&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
