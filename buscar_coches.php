<?php
$conexion = mysqli_connect("localhost", "root", "rootroot", "concesionario");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$busqueda = "";
$resultado = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $busqueda = trim($_POST["busqueda"]);
    $busqueda = mysqli_real_escape_string($conexion, $busqueda); // Protección contra inyección SQL

    $sql = "SELECT * FROM Coches WHERE modelo LIKE '%$busqueda%' OR marca LIKE '%$busqueda%'";
    $resultado = $conexion->query($sql);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buscar Coche</title>

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
                    <li class="nav-item"><a class="nav-link" href="coches.php">Volver</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Buscar Coche</h2>
        
        <div class="card p-4 mx-auto mt-4" style="max-width: 500px;">
            <form method="post">
                <div class="mb-3">
                    <input type="text" name="busqueda" class="form-control" placeholder="Modelo o Marca" value="<?= htmlspecialchars($busqueda) ?>">
                </div>
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </form>
        </div>

        <div class="mt-4">
            <?php if ($resultado && $resultado->num_rows > 0) { ?>
                <h3 class="text-center">Resultados:</h3>
                <div class="list-group mt-3">
                    <?php while ($fila = $resultado->fetch_assoc()) { ?>
                        <a href="editar_coche.php?id=<?= $fila['id_coche'] ?>" class="list-group-item list-group-item-action">
                            <strong><?= htmlspecialchars($fila["modelo"]) ?></strong> (Marca: <?= htmlspecialchars($fila["marca"]) ?>)
                        </a>
                    <?php } ?>
                </div>
            <?php } elseif ($busqueda) { ?>
                <div class="alert alert-warning text-center mt-3">No se encontraron resultados.</div>
            <?php } ?>
        </div>
    </div>

    <footer class="footer mt-5">
        <p class="text-center">&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
