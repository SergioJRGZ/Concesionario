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

// Obtener la lista de coches
$sql = "SELECT id_coche, modelo, marca, color, precio, alquilado, foto FROM Coches";
$resultado = mysqli_query($conn, $sql);

// Verificar el tipo de usuario
$tipo_usuario = isset($_SESSION["tipo"]) ? $_SESSION["tipo"] : null;
$id_usuario = isset($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Coches</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
                    <?php if (isset($_SESSION["nombre"])) { ?>
                        <li class="nav-item">
                            <span class="nav-link text-white">Bienvenido, <strong><?= htmlspecialchars($_SESSION["nombre"]) ?></strong></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="mis_alquileres.php">Mis Alquileres</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-danger text-white ms-3" href="cerrar_sesion.php">Cerrar Sesión</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>
                        <li class="nav-item"><a class="nav-link" href="registro.php">Registrarse</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido -->
    <div class="container mt-5">
        <h2 class="text-center">Lista de Coches</h2>

        <!-- Botón para agregar coches (solo administradores y vendedores) -->
        <?php if ($tipo_usuario === "administrador" || $tipo_usuario === "vendedor") { ?>
            <div class="text-center mt-4">
                <a href="añadir_coches.php" class="btn btn-success">➕ Agregar Coche</a>
            </div>
        <?php } ?>

        <div class="table-responsive mt-4">
            <table class="table table-dark table-striped text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Color</th>
                        <th>Precio (€)</th>
                        <th>Estado</th>
                        <?php if ($tipo_usuario === "comprador") { ?>
                        <th>Alquilar</th>
                        <?php } ?>
                        <?php if ($tipo_usuario === "vendedor" || $tipo_usuario === "administrador") { ?>
                        <th>Acciones</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = mysqli_fetch_assoc($resultado)) { 
                        // Definir la ruta de la imagen
                        $ruta_imagen = "img/" . htmlspecialchars($fila["foto"]);

                        // Verificar si la imagen existe, si no, usar imagen por defecto
                        if (!file_exists($ruta_imagen) || empty($fila["foto"])) {
                            $ruta_imagen = "img/default-car.jpg"; // Imagen por defecto
                        }
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($fila["id_coche"]) ?></td>
                        <td>
                            <img src="<?= $ruta_imagen ?>" 
                                 alt="Imagen del coche" 
                                 class="img-thumbnail" 
                                 style="width: 100px; height: auto;">
                        </td>
                        <td><?= htmlspecialchars($fila["modelo"]) ?></td>
                        <td><?= htmlspecialchars($fila["marca"]) ?></td>
                        <td><?= htmlspecialchars($fila["color"]) ?></td>
                        <td><?= number_format($fila["precio"], 2) ?> €</td>
                        <td>
                            <?= $fila["alquilado"] ? "<span class='text-danger'>Alquilado</span>" : "<span class='text-success'>Disponible</span>" ?>
                        </td>
                        
                        <!-- Botón de alquilar para compradores -->
                        <?php if ($tipo_usuario === "comprador") { ?>
                        <td>
                            <?php if ($fila["alquilado"] == 0) { ?>
                                <a href="alquilar_coche.php?id=<?= $fila['id_coche'] ?>" class="btn btn-primary btn-sm">Alquilar</a>
                            <?php } else { ?>
                                <span class="text-danger">No disponible</span>
                            <?php } ?>
                        </td>
                        <?php } ?>

                        <!-- Acciones solo para vendedores y administradores -->
                        <?php if ($tipo_usuario === "vendedor" || $tipo_usuario === "administrador") { ?>
                        <td>
                            <a href="modificar_coches.php?id=<?= $fila['id_coche'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="eliminar_coche.php?id=<?= $fila['id_coche'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar coche?')">Eliminar</a>
                        </td>
                        <?php } ?>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-primary">Volver</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-5">
        <p class="text-center">&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($conn); ?>
