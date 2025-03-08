<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "rootroot", "concesionario");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["id_usuario"])) {
    die("Acceso denegado. Debes iniciar sesión.");
}

$id_usuario = $_SESSION["id_usuario"];

// Obtener los alquileres del usuario actual
$sql = "SELECT A.id_alquiler, C.id_coche, C.modelo, C.marca, C.color, C.precio, A.prestado, A.devuelto 
        FROM Alquileres A
        JOIN Coches C ON A.id_coche = C.id_coche
        WHERE A.id_usuario = $id_usuario
        ORDER BY A.prestado DESC";

$resultado = mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis Alquileres</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-dark text-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Concesionario</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Mis Alquileres</h2>

        <?php if (isset($_GET['mensaje'])) { ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($_GET['mensaje']) ?></div>
        <?php } ?>

        <div class="table-responsive">
            <table class="table table-dark table-striped mt-4">
                <thead>
                    <tr>
                        <th>ID Alquiler</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Color</th>
                        <th>Precio (€)</th>
                        <th>Fecha de Alquiler</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
                        <tr>
                            <td><?= $fila["id_alquiler"] ?></td>
                            <td><?= htmlspecialchars($fila["modelo"]) ?></td>
                            <td><?= htmlspecialchars($fila["marca"]) ?></td>
                            <td><?= htmlspecialchars($fila["color"]) ?></td>
                            <td><?= number_format($fila["precio"], 2) ?> €</td>
                            <td><?= $fila["prestado"] ?></td>
                            <td>
                                <?= $fila["devuelto"] ? "<span class='text-success'>Devuelto</span>" : "<span class='text-warning'>En uso</span>" ?>
                            </td>
                            <td>
                                <?php if (!$fila["devuelto"]) { ?>
                                    <a href="devolver_coche.php?id=<?= $fila['id_alquiler'] ?>" class="btn btn-danger btn-sm">Devolver</a>
                                <?php } else { ?>
                                    <span class="text-muted">Finalizado</span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <footer class="footer text-center mt-5">
        <p>&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($conn); ?>
