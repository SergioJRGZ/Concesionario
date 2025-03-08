<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "rootroot", "concesionario");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Verificar permisos
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== "administrador") {
    header("Location: listar_usuarios.php?error=Acceso denegado");
    exit();
}

if (isset($_GET["id"])) {
    $id_usuario = intval($_GET["id"]);
    
    // Eliminar usuario si existe
    $sql = "DELETE FROM Usuarios WHERE id_usuario = $id_usuario";
    
    if (mysqli_query($conexion, $sql) && mysqli_affected_rows($conexion) > 0) {
        header("Location: listar_usuarios.php?mensaje=Usuario eliminado correctamente");
    } else {
        header("Location: listar_usuarios.php?error=El usuario no existe o no pudo ser eliminado");
    }
    exit();
} else {
    header("Location: listar_usuarios.php?error=ID de usuario no válido");
    exit();
}

mysqli_close($conexion);
?>

