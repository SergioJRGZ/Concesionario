<?php
session_start();
if (!isset($_SESSION["id_usuario"]) || $_SESSION["tipo"] != "vendedor") {
    header("Location: login.php");
    exit();
}

$conexion = mysqli_connect("localhost", "root", "rootroot", "concesionario");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$coche = null;

if (isset($_GET["id"])) {
    $id_coche = intval($_GET["id"]);
    $sql = "SELECT * FROM Coches WHERE id_coche = $id_coche";
    $resultado = mysqli_query($conexion, $sql);
    $coche = mysqli_fetch_assoc($resultado);

    if (!$coche) {
        die("Coche no encontrado.");
    }
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_coche = intval($_POST["id_coche"]);
    $modelo = isset($_POST["modelo"]) ? htmlspecialchars($_POST["modelo"]) : "";
    $marca = isset($_POST["marca"]) ? htmlspecialchars($_POST["marca"]) : "";
    $color = isset($_POST["color"]) ? htmlspecialchars($_POST["color"]) : "";
    $precio = isset($_POST["precio"]) ? floatval($_POST["precio"]) : 0;
    $foto = isset($_POST["foto"]) ? htmlspecialchars($_POST["foto"]) : "";

    $sql = "UPDATE Coches SET modelo='$modelo', marca='$marca', color='$color', precio=$precio, foto='$foto' WHERE id_coche=$id_coche";
    
    if (mysqli_query($conexion, $sql)) {
        $mensaje = "<div class='alert alert-success text-center'>Coche actualizado correctamente. <a href='mis_coches.php' class='alert-link'>Volver</a></div>";
    } else {
        $mensaje = "<div class='alert alert-danger text-center'>Error al actualizar el coche.</div>";
    }
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Coche</title>

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
                    <li class="nav-item"><a class="nav-link" href="mis_coches.php">Mis Coches</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Editar Coche</h2>

        <?= $mensaje; ?>

        <div class="card p-4 mx-auto mt-4" style="max-width: 500px;">
            <form method="post">
                <input type="hidden" name="id_coche" value="<?= htmlspecialchars($coche['id_coche']) ?>">

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

                <div class="mb-3">
                    <label class="form-label">Foto (URL):</label>
                    <input type="text" name="foto" class="form-control" value="<?= htmlspecialchars($coche['foto']) ?>" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Actualizar Coche</button>
            </form>
        </div>

        <div class="text-center mt-4">
            <a href="mis_coches.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>

    <footer class="footer mt-5">
        <p class="text-center">&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
