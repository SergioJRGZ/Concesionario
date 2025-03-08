<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agregar Usuario</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

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
        .footer {
            background-color: #343a40;
            padding: 15px;
            text-align: center;
            color: #ffffff;
            margin-top: 30px;
        }
        .alert {
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">🚗 Concesionario</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="listar_usuarios.php">👥 Ver Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="usuarios.php">🔙 Volver</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center fw-bold">👤 Agregar Usuario</h2>
        <p class="text-center text-secondary">Complete los campos para registrar un nuevo usuario.</p>

        <div class="container">
            <?php echo $mensaje; ?>
        </div>
        <div class="card p-4 mx-auto mt-4" style="max-width: 500px;">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Nombre:</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Apellidos:</label>
                    <input type="text" name="apellidos" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">DNI:</label>
                    <input type="text" name="dni" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Saldo (€):</label>
                    <input type="number" name="saldo" class="form-control" step="0.01" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">✅ Agregar Usuario</button>
            </form>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
