<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "rootroot", "concesionario");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = isset($_POST["nombre"]) ? htmlspecialchars($_POST["nombre"]) : "";
    $apellidos = isset($_POST["apellidos"]) ? htmlspecialchars($_POST["apellidos"]) : "";
    $dni = isset($_POST["dni"]) ? htmlspecialchars($_POST["dni"]) : "";
    $password = isset($_POST["password"]) ? password_hash($_POST["password"], PASSWORD_DEFAULT) : "";
    $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
    $saldo = 0;
    // Verificar si el DNI ya está registrado
    $sql_check = "SELECT id_usuario FROM Usuarios WHERE dni = '$dni'";
    $result = mysqli_query($conexion, $sql_check);
    if (mysqli_num_rows($result) > 0) {
        echo "Error: El DNI ya está registrado.";
    } else {
        // Insertar el usuario
        $sql = "INSERT INTO Usuarios (nombre, apellidos, dni, password, tipo, saldo) VALUES ('$nombre', '$apellidos', '$dni', '$password', '$tipo', $saldo)";
        
        if (mysqli_query($conexion, $sql)) {
            echo "Registro exitoso. <a href='login.php'>Iniciar sesión</a>";
        } else {
            echo "Error en el registro.";
        }
    }
}
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Usuario</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-dark text-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Concesionario</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Volver al inicio</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container d-flex flex-column justify-content-center align-items-center vh-100">
        <div class="card p-4 bg-secondary text-light" style="max-width: 400px; width: 100%;">
            <h2 class="text-center">Registro de Usuario</h2>

            <?= $mensaje; ?>

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
                    <label class="form-label">Tipo de Usuario:</label>
                    <select name="tipo" class="form-control" required>
                        <option value="comprador">Comprador</option>
                        <option value="vendedor">Vendedor</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">Registrarse</button>
            </form>

            <div class="text-center mt-3">
                <a href="index.php" class="text-light">Volver al inicio</a>
            </div>
        </div>
    </div>

    <footer class="footer text-center mt-5">
        <p>&copy; 2025 Concesionario. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
