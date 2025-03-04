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

// Verificar si el usuario ha iniciado sesión y es comprador
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== "comprador") {
    die("Acceso denegado. Solo los compradores pueden alquilar coches.");
}

// Verificar que se haya recibido un ID de coche
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Error: No se recibió un ID de coche válido.");
}

$id_coche = intval($_GET["id"]);
$id_usuario = $_SESSION["id_usuario"];

// Verificar si el coche ya está alquilado
$sql_check = "SELECT alquilado FROM Coches WHERE id_coche = ?";
$stmt_check = mysqli_prepare($conn, $sql_check);
mysqli_stmt_bind_param($stmt_check, "i", $id_coche);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);
$fila = mysqli_fetch_assoc($result_check);

if (!$fila) {
    die("Error: El coche no existe.");
}

if ($fila["alquilado"] == 1) {
    die("Error: Este coche ya está alquilado.");
}

// Iniciar transacción para evitar inconsistencias
mysqli_begin_transaction($conn);

try {
    // Marcar el coche como alquilado
    $sql_update = "UPDATE Coches SET alquilado = 1 WHERE id_coche = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "i", $id_coche);
    if (!mysqli_stmt_execute($stmt_update)) {
        throw new Exception("Error al actualizar el estado del coche.");
    }

    // Registrar el alquiler en la tabla Alquileres
    $sql_insert = "INSERT INTO Alquileres (id_usuario, id_coche, prestado) VALUES (?, ?, NOW())";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);
    mysqli_stmt_bind_param($stmt_insert, "ii", $id_usuario, $id_coche);
    if (!mysqli_stmt_execute($stmt_insert)) {
        throw new Exception("Error al registrar el alquiler.");
    }

    // Confirmar la transacción
    mysqli_commit($conn);

    // Redirigir a mis_alquileres.php con mensaje de éxito
    header("Location: mis_alquileres.php?mensaje=¡Coche alquilado con éxito!");
    exit();

} catch (Exception $e) {
    // Revertir cambios en caso de error
    mysqli_rollback($conn);
    die("Error: " . $e->getMessage());
}

// Cerrar conexión
mysqli_close($conn);
?>
