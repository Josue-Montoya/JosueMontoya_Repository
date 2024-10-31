<?php
session_start();
if ($_SESSION['user'] == "" || $_SESSION['user'] != "administrador") {
    header("Location: ../../views/products.php");
}

include '../../conf/conf.php';

if (isset($_GET['id'])) {
    $idProducto = $_GET['id'];

    // Obtener datos del producto
    $query = "SELECT * FROM tbl_productos WHERE id_producto = :idProducto";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':idProducto', $idProducto);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        header("Location: ../../views/products.php");
        exit();
    }
} else {
    header("Location: ../../views/products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Editar Producto</h1>
    <form action="../../controllers/Products/editProductController.php" method="POST">
        <input type="hidden" name="id_producto" value="<?php echo $product['id_producto']; ?>">
        
        <div class="form-group">
            <label for="nombreProducto">Nombre del Producto:</label>
            <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" value="<?php echo htmlspecialchars($product['nombreProducto']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($product['descripcion']); ?>">
        </div>
        
        <div class="form-group">
            <label for="precioUnitario">Precio Unitario:</label>
            <input type="number" step="0.01" class="form-control" id="precioUnitario" name="precioUnitario" value="<?php echo $product['precioUnitario']; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Guardar Cambios</button>
        <a href="../../views/products.php" class="btn btn-danger mt-4">Cancelar</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
