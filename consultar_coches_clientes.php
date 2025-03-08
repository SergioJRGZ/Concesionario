<?php
$conexion = mysqli_connect("localhost", "root", "rootroot", "concesionario");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Seleccionar los coches que no están alquilados
$sql = "SELECT * FROM Coches WHERE alquilado = 0";  
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consultar Coches Disponibles</title>

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
                    <li class="nav-item"><a class="nav-link" href="login.php">Iniciar sesión</a></li>
                    <li class="nav-item"><a class="nav-link" href="registro.php">Registrarse</a></li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container mt-5">
        <h2 class="text-center">Consultar Coches Disponibles</h2>


        <div class="table-responsive mt-4">
            <table class="table table-dark table-striped text-center">
                <thead>
                    <tr>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Color</th>
                        <th>Precio</th>
                        <th>Foto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = $resultado->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($fila["modelo"]) ?></td>
                        <td><?= htmlspecialchars($fila["marca"]) ?></td>
                        <td><?= htmlspecialchars($fila["color"]) ?></td>
                        <td><?= number_format($fila["precio"], 2) ?> €</td>
                        <td><img src="<?= htmlspecialchars($fila["foto"]) ?>" class="img-fluid rounded" width="100"></td>
                        <td>
                            <a href="ver_coche.php?id=<?= $fila['id_coche'] ?>" class="btn btn-info btn-sm">Ver Detalles</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="login.php" class="btn btn-primary">Iniciar sesión</a>
            <a href="registro.php" class="btn btn-success">Registrarse</a>
        </div>
    </div>

    <footer class="footer mt-5">
        <p class="text-center">&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
