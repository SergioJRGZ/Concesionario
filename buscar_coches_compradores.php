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

$sql = "SELECT * FROM Coches WHERE alquilado = 0";  // Solo coches no alquilados
if (isset($_REQUEST["buscar"])) {
    $modelo = $_REQUEST["modelo"];
    $marca = $_REQUEST["marca"];
    $precio = $_REQUEST["precio"];

    if (!empty($modelo)) {
        $sql .= " AND modelo LIKE '%$modelo%'";
    }
    if (!empty($marca)) {
        $sql .= " AND marca LIKE '%$marca%'";
    }
    if (!empty($precio)) {
        $sql .= " AND precio <= $precio";
    }
}

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buscar Coches Disponibles</title>

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
                    <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-5">
        <h2 class="text-center">Buscar Coches Disponibles</h2>

        <div class="card p-4 mx-auto mt-4" style="max-width: 600px;">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Modelo:</label>
                    <input type="text" name="modelo" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Marca:</label>
                    <input type="text" name="marca" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Precio máximo:</label>
                    <input type="number" name="precio" class="form-control" step="0.01">
                </div>

                <button type="submit" name="buscar" class="btn btn-primary w-100">Buscar</button>
            </form>
        </div>

        <h3 class="text-center mt-5">Resultados de la búsqueda:</h3>

        <div class="table-responsive mt-3">
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
                        <td><img src="<?= htmlspecialchars($fila["foto"]) ?>" class="img-fluid" width="100"></td>
                        <td>
                            <a href="ver_coche.php?id=<?= $fila['id_coche'] ?>" class="btn btn-warning btn-sm">Ver</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

    <footer class="footer mt-5">
        <p class="text-center">&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
