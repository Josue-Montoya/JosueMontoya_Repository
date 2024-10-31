<?php 
session_start(); 
if (!isset($_SESSION['user']) || $_SESSION['user'] != "administrador") {     
    header("Location: ../../views/admin.php");     
    exit(); 
}  
// Incluye el controlador para obtener datos del usuario 
include '../../conf/conf.php'; 

// Obtener el ID del usuario a eliminar
$id_usuario = isset($_GET['id']) ? $_GET['id'] : null;

// Si no hay ID, redirigir
if (!$id_usuario) {
    header("Location: ../../views/users/indexUser.php");
    exit();
}

// Obtener datos del usuario
try {
    $stmt = $connection->prepare("SELECT * FROM tbl_usuarios WHERE id_usuario = :id_usuario");
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$usuario) {
        header("Location: ../../views/users/indexUser.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>  
<!DOCTYPE html> 
<html lang="es">  
<head>     
    <meta charset="UTF-8">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">     
    <title>Eliminar Usuario</title>     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">     
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">     
</head>  

<body>  
<div class="container mt-5">     
    <div class="card">
        <div class="card-header bg-danger text-white">
            <h1 class="mb-0">Eliminar Usuario</h1>
        </div>
        <div class="card-body">
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                ¿Está seguro que desea eliminar el siguiente usuario?
            </div>
            
            <div class="user-info mb-4">
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre']); ?></p>
                <p><strong>Usuario:</strong> <?php echo htmlspecialchars($usuario['usuario']); ?></p>
                <p><strong>Rol:</strong> <?php echo $usuario['id_rol'] == 1 ? 'Administrador' : 'Empleado'; ?></p>
            </div>
            
            <form action="../../controllers/Users/deleteUserController.php" method="POST" class="d-inline">         
                <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i> Confirmar Eliminación
                </button>
                <a href="../../views/users/indexUser.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </form>
        </div>
    </div>
</div>  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
</body> 
</html>