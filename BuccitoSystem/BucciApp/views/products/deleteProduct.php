<?php
session_start();
if ($_SESSION['user'] == "" || $_SESSION['user'] != "administrador") {
    header("Location: ../views/products.php");
    exit();
}

if (!isset($product)) {
    echo "Error: Producto no encontrado.";
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
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Eliminar Producto</h1>
    <p>¿Estás seguro de que deseas eliminar el siguiente producto?</p>
    <ul>
        <li><strong>ID:</strong> <?php echo htmlspecialchars($product['id_producto']); ?></li>
        <li><strong>Nombre:</strong> <?php echo htmlspecialchars($product['nombreProducto']); ?></li>
        <li><strong>Descripción:</strong> <?php echo htmlspecialchars($product['descripcion']); ?></li>
        <li><strong>Precio Unitario:</strong> <?php echo "$" . number_format($product['precioUnitario'], 2); ?></li>
    </ul>

    <form action="../../controllers/Products/deleteProductController.php" method="POST">
        <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($product['id_producto']); ?>">
        <button type="submit" class="btn btn-danger">Eliminar</button>
        <a href="../../views/admin.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
