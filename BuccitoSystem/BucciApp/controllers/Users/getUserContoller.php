<?php
include '../../conf/conf.php';

try {
    // Verifica que se hayan pasado los parámetros necesarios
    if (!isset($_GET['id']) || !isset($_GET['action'])) {
        throw new Exception("Faltan parámetros requeridos.");
    }

    $idUsuario = $_GET['id'];
    $action = $_GET['action'];

    // Consulta para obtener los detalles del usuario por su ID
    $sql = "SELECT 
                id_usuario, 
                nombre, 
                usuario, 
                clave, 
                id_rol 
            FROM 
                tbl_usuarios 
            WHERE 
                id_usuario = :idUsuario";

    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        throw new Exception("No se encontró el usuario.");
    }

    // Selección de vista según la acción
    if ($action == 'edit') {
        include '../../views/users/editUser.php'; // Cambia a tu vista de edición de usuario
    } else if ($action == 'delete') {
        include '../../views/users/deleteUser.php'; // Cambia a tu vista de eliminación de usuario
    } else {
        throw new Exception("Acción no válida.");
    }
} catch (PDOException $e) {
    echo "Error al obtener el usuario: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
