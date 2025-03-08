<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "rootroot", "concesionario");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (!isset($_SESSION['tipo'])) {
    die("Acceso denegado. No tienes permisos para ver esta página.");
}

$tipo = $_SESSION['tipo'];
$resultado = null;

if ($tipo == "vendedor") {
    $resultado = mysqli_query($conexion, "SELECT * FROM Coches WHERE alquilado = 0");
} elseif ($tipo == "administrador") {
    $resultado = mysqli_query($conexion, "SELECT * FROM Coches");
}

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Coches</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Concesionario</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="coches.php">Volver</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Lista de Coches</h2>

        <div class="table-responsive mt-4">
            <table class="table table-dark table-striped text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Color</th>
                        <th>Precio (€)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($fila["id_coche"]) ?></td>
                        <td><?= htmlspecialchars($fila["modelo"]) ?></td>
                        <td><?= htmlspecialchars($fila["marca"]) ?></td>
                        <td><?= htmlspecialchars($fila["color"]) ?></td>
                        <td><?= number_format($fila["precio"], 2) ?></td>
                        <?php if ($tipo == "vendedor" || $tipo == "administrador") { ?>
                        <td>
                            <a href="modificar_coches.php?id=<?= $fila['id_coche'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="eliminar_coches.php?id=<?= $fila['id_coche'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar coche?')">Eliminar</a>
                        </td>
                        <?php } ?>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="coches.php" class="btn btn-primary">Volver</a>
        </div>
    </div>

    <footer class="footer mt-5">
        <p class="text-center">&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
