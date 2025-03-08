<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "rootroot", "concesionario");
if (mysqli_connect_errno()) {
    die("Error de conexión: " . mysqli_connect_error());
}
$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["dni"]) || empty($_POST["password"])) {
        $mensaje = "Por favor, completa todos los campos.";
    } else {
        $dni = trim($_POST["dni"]);
        $password = trim($_POST["password"]);

        $sql = "SELECT id_usuario, nombre, tipo, password FROM Usuarios WHERE dni = ?";
        $stmt = mysqli_prepare($conexion, $sql);

        if (!$stmt) {
            $mensaje = "Error en la consulta: " . mysqli_error($conexion);
        } else {
            mysqli_stmt_bind_param($stmt, "s", $dni);
            if (!mysqli_stmt_execute($stmt)) {
                $mensaje = "Error al ejecutar la consulta.";
            } else {
                $result = mysqli_stmt_get_result($stmt);
                if (!$result) {
                    $mensaje = "Error al obtener los resultados.";
                } else {
                    if (mysqli_num_rows($result) == 1) {
                        $usuario = mysqli_fetch_assoc($result);
                        if (password_verify($password, $usuario["password"])) {
                            $_SESSION["id_usuario"] = $usuario["id_usuario"];
                            $_SESSION["nombre"] = $usuario["nombre"];
                            $_SESSION["tipo"] = $usuario["tipo"];
                            
                            header("Location: index.php?login=success");
                            exit;
                        } else {
                            $mensaje = "Contraseña incorrecta.";
                        }
                    } else {
                        $mensaje = "Usuario no encontrado.";
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-dark text-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Concesionario</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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
            <h2 class="text-center">Iniciar Sesión</h2>
            <?php if (!empty($mensaje)) { ?>
                <div class="alert alert-warning text-center"><?= htmlspecialchars($mensaje) ?></div>
            <?php } ?>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">DNI</label>
                    <input type="text" name="dni" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
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
