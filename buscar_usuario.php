<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buscar Usuario</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background-color: #121212; /* Fondo oscuro */
            color: #f8f9fa; /* Texto blanco */
        }
        .navbar {
            background-color: #343a40 !important; /* Color oscuro para navbar */
        }
        .card {
            background-color: #212529; /* Fondo oscuro para el formulario */
            color: #f8f9fa; /* Texto blanco */
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(255, 255, 255, 0.1); /* Sombra suave */
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px;
            font-size: 18px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .list-group-item {
            background-color: #2c3034;
            color: white;
            border: 1px solid #444;
            transition: background 0.3s;
        }
        .list-group-item:hover {
            background-color: #3a3f44;
        }
        .alert-warning {
            background-color: #856404;
            color: #fff3cd;
            border-radius: 5px;
        }
        .footer {
            background-color: #343a40;
            padding: 15px;
            text-align: center;
            color: #ffffff;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">🚗 Concesionario</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="usuarios.php">🔙 Volver</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <h2 class="text-center fw-bold">🔍 Buscar Usuario</h2>
        <p class="text-center text-secondary">Introduce el nombre o DNI del usuario que deseas buscar.</p>

        <!-- Formulario de búsqueda -->
        <div class="card p-4 mx-auto mt-4" style="max-width: 500px;">
            <form method="post">
                <div class="mb-3">
                    <input type="text" name="busqueda" class="form-control" placeholder="Nombre o DNI" value="<?= htmlspecialchars($busqueda) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">🔎 Buscar</button>
            </form>
        </div>

        <!-- Resultados de la búsqueda -->
        <div class="mt-4">
            <?php if ($resultado && $resultado->num_rows > 0) { ?>
                <h3 class="text-center">📋 Resultados:</h3>
                <div class="list-group mt-3">
                    <?php while ($fila = $resultado->fetch_assoc()) { ?>
                        <a href="editar_usuario.php?id=<?= $fila['id_usuario'] ?>" class="list-group-item list-group-item-action">
                            <strong><?= htmlspecialchars($fila["nombre"]) ?></strong> (DNI: <?= htmlspecialchars($fila["dni"]) ?>)
                        </a>
                    <?php } ?>
                </div>
            <?php } elseif ($busqueda) { ?>
                <div class="alert alert-warning text-center mt-3">⚠ No se encontraron resultados.</div>
            <?php } ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
