<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "rootroot";
$db = "concesionario";
$conn = mysqli_connect($host, $user, $pass, $db);

// Verificar conexión
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Verificar si el usuario ha iniciado sesión y si es comprador, vendedor o administrador
if (!isset($_SESSION["tipo"]) || ($_SESSION["tipo"] !== "administrador" && $_SESSION["tipo"] !== "comprador" && $_SESSION["tipo"] !== "vendedor")) {
    die("Acceso denegado. Debes ser administrador, vendedor o comprador para agregar coches.");
}

$mensaje = "";

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $modelo = htmlspecialchars(trim($_POST["modelo"]));
    $marca = htmlspecialchars(trim($_POST["marca"]));
    $color = htmlspecialchars(trim($_POST["color"]));
    $precio = floatval($_POST["precio"]);
    $foto = htmlspecialchars(trim($_POST["foto"]));

    if (!empty($modelo) && !empty($marca) && !empty($color) && $precio > 0 && !empty($foto)) {
        $sql = "INSERT INTO Coches (modelo, marca, color, precio, alquilado, foto) 
                VALUES (?, ?, ?, ?, 0, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssds", $modelo, $marca, $color, $precio, $foto);

        if (mysqli_stmt_execute($stmt)) {
            $mensaje = "<div class='alert alert-success text-center'>Coche agregado correctamente. <a href='listar_coches.php' class='alert-link'>Ver coches</a></div>";
        } else {
            $mensaje = "<div class='alert alert-danger text-center'>Error al agregar el coche.</div>";
        }
        mysqli_stmt_close($stmt);
    } else {
        $mensaje = "<div class='alert alert-warning text-center'>Todos los campos son obligatorios.</div>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agregar Coche</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-dark text-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Concesionario</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="listar_coches.php">Ver Coches</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-danger text-white ms-3" href="cerrar_sesion.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <h2 class="text-center">Agregar Coche</h2>

        <?= $mensaje; ?>

        <div class="card p-4 mx-auto mt-4 bg-secondary text-light" style="max-width: 500px;">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Modelo:</label>
                    <input type="text" name="modelo" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Marca:</label>
                    <input type="text" name="marca" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Color:</label>
                    <input type="text" name="color" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Precio (€):</label>
                    <input type="number" name="precio" step="0.01" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto (URL):</label>
                    <input type="text" name="foto" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Agregar Coche</button>
            </form>
        </div>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-secondary">Volver</a>
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
