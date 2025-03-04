<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "rootroot", "concesionario");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consulta para obtener los alquileres con información de usuario y coche
$sql = "SELECT A.id_alquiler, U.nombre, U.apellidos, U.dni, 
               C.modelo, C.marca, C.color, A.prestado, A.devuelto 
        FROM Alquileres A
        JOIN Usuarios U ON A.id_usuario = U.id_usuario
        JOIN Coches C ON A.id_coche = C.id_coche";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alquileres</title>
    <link rel="stylesheet" href="css/styles.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-dark text-light">

<div class="container mt-5">
    <h2 class="text-center text-warning">Lista de Alquileres</h2>
    
    <table class="table table-dark table-striped mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>DNI</th>
                <th>Coche</th>
                <th>Color</th>
                <th>Fecha Prestado</th>
                <th>Fecha Devuelto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?= $fila["id_alquiler"] ?></td>
                <td><?= $fila["nombre"] . " " . $fila["apellidos"] ?></td>
                <td><?= $fila["dni"] ?></td>
                <td><?= $fila["modelo"] . " - " . $fila["marca"] ?></td>
                <td><?= $fila["color"] ?></td>
                <td><?= $fila["prestado"] ?></td>
                <td><?= $fila["devuelto"] ?></td>
                <td>
                    <a href="eliminar_alquiler.php?id=<?= $fila['id_alquiler'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar alquiler?')">
                        Eliminar
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="text-center">
        <a href="alquileres.php" class="btn btn-primary">Volver</a>
    </div>
</div>

</body>
</html>
