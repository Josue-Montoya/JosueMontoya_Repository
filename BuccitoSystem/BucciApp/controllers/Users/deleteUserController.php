<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] != "administrador") {     
    header("Location: ../../views/admin.php");     
    exit(); 
}

include '../../conf/conf.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_usuario'];
    
    try {
        // Primero verificamos que el usuario exista y no sea el último administrador
        $stmt = $connection->prepare("SELECT COUNT(*) as admin_count FROM tbl_usuarios WHERE id_rol = 1");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt = $connection->prepare("SELECT id_rol FROM tbl_usuarios WHERE id_usuario = :id_usuario");
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Si es el último administrador, no permitir la eliminación
        if ($usuario['id_rol'] == 1 && $result['admin_count'] <= 1) {
            $_SESSION['error'] = "No se puede eliminar el último administrador del sistema.";
            header("Location: ../../views/users/indexUser.php");
            exit();
        }
        
        // Proceder con la eliminación
        $stmt = $connection->prepare("DELETE FROM tbl_usuarios WHERE id_usuario = :id_usuario");
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        
        $_SESSION['success'] = "Usuario eliminado correctamente.";
        header("Location: ../../views/users/indexUser.php");
        exit();
        
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al eliminar el usuario: " . $e->getMessage();
        header("Location: ../../views/users/indexUser.php");
        exit();
    }
} else {
    header("Location: ../../views/users/indexUser.php");
    exit();
}
?>