<?php
session_start();
if ($_SESSION['user'] == "" || $_SESSION['user'] != "administrador") {
    header("Location: ../views/products.php");
    exit();
}

// Incluir configuración de base de datos
include '../../conf/conf.php';

// Obtener el ID del producto a eliminar
$id_producto = isset($_GET['id']) ? $_GET['id'] : null;

// Si no hay ID, redirigir
if (!$id_producto) {
    header("Location: ../../views/products/indexProduct.php");
    exit();
}

// Obtener datos del producto
try {
    $stmt = $connection->prepare("SELECT * FROM tbl_productos WHERE id_producto = :id_producto");
    $stmt->bindParam(':id_producto', $id_producto);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        header("Location: ../../views/products/indexProduct.php");
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
    <title>Eliminar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-danger text-white">
            <h1 class="mb-0">Eliminar Producto</h1>
        </div>
        <div class="card-body">
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                ¿Está seguro que desea eliminar el siguiente producto?
            </div>
            
            <div class="product-info mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong><i class="fas fa-hashtag me-2"></i>ID:</strong>
                            <span><?php echo htmlspecialchars($product['id_producto']); ?></span>
                        </div>
                        <div class="mb-3">
                            <strong><i class="fas fa-box me-2"></i>Nombre:</strong>
                            <span><?php echo htmlspecialchars($product['nombreProducto']); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong><i class="fas fa-dollar-sign me-2"></i>Precio Unitario:</strong>
                            <span><?php echo "$" . number_format($product['precioUnitario'], 2); ?></span>
                        </div>
                        <div class="mb-3">
                            <strong><i class="fas fa-align-left me-2"></i>Descripción:</strong>
                            <span><?php echo htmlspecialchars($product['descripcion']); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <form action="../../controllers/Products/deleteProductController.php" method="POST" class="d-inline">
                <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($product['id_producto']); ?>">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash-alt me-2"></i>Confirmar Eliminación
                </button>
                <a href="../../views/admin.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Cancelar
                </a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>