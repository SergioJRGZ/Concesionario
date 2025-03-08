<?php
session_start();
$servername = "localhost";
$user = "root";
$pass = "rootroot";
$db = "concesionario";
$conn = mysqli_connect($servername, $user, $pass, $db);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== "comprador") {
    die("Acceso denegado. Solo los compradores pueden alquilar coches.");
}
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Error: No se recibió un ID de coche válido.");
}

$id_coche = intval($_GET["id"]);
$id_usuario = $_SESSION["id_usuario"];

$result_check = mysqli_query($conn, "SELECT alquilado FROM Coches WHERE id_coche = $id_coche");
$fila = mysqli_fetch_assoc($result_check);

if (!$fila) {
    die("Error: El coche no existe.");
}
if ($fila["alquilado"]) {
    die("Error: Este coche ya está alquilado.");
}

mysqli_begin_transaction($conn);

// se lanza new exception para ver los errores por mensajes
try {
    if (!mysqli_query($conn, "UPDATE Coches SET alquilado = 1 WHERE id_coche = $id_coche")) {
        throw new Exception("Error al actualizar el estado del coche.");
    }
    
    if (!mysqli_query($conn, "INSERT INTO Alquileres (id_usuario, id_coche, prestado) VALUES ($id_usuario, $id_coche, NOW())")) {
        throw new Exception("Error al registrar el alquiler.");
    }
    
    mysqli_commit($conn);
    header("Location: mis_alquileres.php?mensaje=¡Coche alquilado con éxito!");
    exit();

} catch (Exception $e) {
    mysqli_rollback($conn);
    die("Error: " . $e->getMessage());
}

mysqli_close($conn);
?>
