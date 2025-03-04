<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "rootroot";
$db = "concesionario";
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener alquileres
$sql = "SELECT A.id_alquiler, U.nombre, U.apellidos, C.modelo, C.marca, C.color, C.precio, A.prestado, A.devuelto 
        FROM Alquileres A
        JOIN Usuarios U ON A.id_usuario = U.id_usuario
        JOIN Coches C ON A.id_coche = C.id_coche
        ORDER BY A.prestado DESC";

$resultado = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Alquileres</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-dark text-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Concesionario</a>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <h2 class="text-center">Gestión de Alquileres</h2>
        <p class="text-center">Aquí puedes ver todos los alquileres activos y finalizados.</p>

        <?php if (isset($_GET['mensaje'])) { ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($_GET['mensaje']) ?></div>
        <?php } ?>

        <div class="table-responsive">
            <table class="table table-dark table-striped mt-4">
                <thead>
                    <tr>
                        <th>ID Alquiler</th>
                        <th>Cliente</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Color</th>
                        <th>Precio (€)</th>
                        <th>Fecha de Alquiler</th>
                        <th>Fecha de Devolución</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
                        <tr>
                            <td><?= $fila["id_alquiler"] ?></td>
                            <td><?= htmlspecialchars($fila["nombre"] . " " . $fila["apellidos"]) ?></td>
                            <td><?= htmlspecialchars($fila["modelo"]) ?></td>
                            <td><?= htmlspecialchars($fila["marca"]) ?></td>
                            <td><?= htmlspecialchars($fila["color"]) ?></td>
                            <td><?= number_format($fila["precio"], 2) ?> €</td>
                            <td><?= $fila["prestado"] ?></td>
                            <td><?= $fila["devuelto"] ? $fila["devuelto"] : "<span class='text-warning'>No devuelto</span>" ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-secondary">Volver al inicio</a>
        </div>
    </div>

    <footer class="footer text-center mt-5">
        <p>&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($conn); ?>
