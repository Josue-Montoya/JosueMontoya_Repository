<?php 
session_start(); 
if (!isset($_SESSION['user']) || $_SESSION['user'] != "administrador") {     
    header("Location: ../../views/admin.php");     
    exit(); 
}  
// Incluye el controlador para obtener datos del usuario 
include '../../conf/conf.php'; 
?>  
<!DOCTYPE html> 
<html lang="es">  
<head>     
    <meta charset="UTF-8">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0">     
    <title>Editar Usuario</title>     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">     
    <!-- Cambiado el CDN de Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">     
    <style>         
        .eye-icon {             
            cursor: pointer;             
            position: absolute;             
            right: 10px;             
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;         
        }
        .password-container {
            position: relative;
        }
    </style> 
</head>  

<body>  
<div class="container mt-5">     
    <h1 class="mb-4">Editar Usuario</h1>     
    <form action="../../controllers/Users/editUserController.php" method="POST">         
        <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">         
        <div class="form-group mb-3">             
            <label for="nombre">Nombre:</label>             
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>         
        </div>         
        <div class="form-group mb-3">             
            <label for="usuario">Usuario:</label>             
            <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $usuario['usuario']; ?>" required>         
        </div>         
        <div class="form-group mb-3">             
            <label for="clave">Clave:</label>             
            <div class="password-container">
                <input type="password" class="form-control" id="clave" name="clave">             
                <span class="eye-icon" id="togglePassword">                 
                    <i class="fas fa-eye"></i>             
                </span>
            </div>         
        </div>         
        <div class="form-group mb-3">             
            <label for="id_rol">Rol:</label>             
            <select class="form-control" id="id_rol" name="id_rol" required>                 
                <option value="1" <?php echo $usuario['id_rol'] == 1 ? 'selected' : ''; ?>>administrador</option>                 
                <option value="2" <?php echo $usuario['id_rol'] == 2 ? 'selected' : ''; ?>>empleado</option>             
            </select>         
        </div>         
        <button type="submit" class="btn btn-primary mt-4">Guardar Cambios</button>         
        <a href="../../views/users/indexUser.php" class="btn btn-danger mt-4">Regresar</a>     
    </form> 
</div>  

<!-- Eliminado el script de Font Awesome ya que usamos el CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
<script>     
    const togglePassword = document.getElementById('togglePassword');     
    const passwordInput = document.getElementById('clave');      
    
    togglePassword.addEventListener('click', function () {         
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';         
        passwordInput.setAttribute('type', type);         
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');     
    }); 
</script> 
</body> 
</html>