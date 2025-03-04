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

// Verificar si el usuario tiene permisos para eliminar
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== "administrador") {
    die("Acceso denegado. No tienes permisos para eliminar usuarios.");
}

// Verificar si se ha pasado un ID de usuario válido
if (isset($_GET["id"])) {
    $id_usuario = intval($_GET["id"]); // Convertir a número entero para seguridad

    // Verificar que el usuario existe antes de eliminarlo
    $sql_check = "SELECT * FROM Usuarios WHERE id_usuario = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "i", $id_usuario);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($result_check) > 0) {
        // El usuario existe, proceder con la eliminación
        $sql_delete = "DELETE FROM Usuarios WHERE id_usuario = ?";
        $stmt_delete = mysqli_prepare($conn, $sql_delete);
        mysqli_stmt_bind_param($stmt_delete, "i", $id_usuario);

        if (mysqli_stmt_execute($stmt_delete)) {
            header("Location: listar_usuarios.php?mensaje=Usuario eliminado correctamente");
            exit();
        } else {
            header("Location: listar_usuarios.php?error=Error al eliminar el usuario");
            exit();
        }
    } else {
        header("Location: listar_usuarios.php?error=El usuario no existe");
        exit();
    }
} else {
    header("Location: listar_usuarios.php?error=ID de usuario no válido");
    exit();
}

mysqli_close($conn);
?>
