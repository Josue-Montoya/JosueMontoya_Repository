<?php
session_start();
if ($_SESSION['user'] == "" || $_SESSION['user'] != "administrador") {
    header("Location: ../../views/admin.php");
}

include '../../controllers/Products/addProductController.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>

<div class="container mt-5">
    <h1 class="mb-4">Administrar Productos</h1>
    <form action="../../controllers/Products/addProductController.php" method="POST">
        <div class="form-group">
            <label for="nombreProducto">Nombre del Producto:</label>
            <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion">
        </div>
        <div class="form-group">
            <label for="precioUnitario">Precio Unitario:</label>
            <input type="number" step="0.01" class="form-control" id="precioUnitario" name="precioUnitario" required>
        </div>
        <button type="submit" class="btn btn-primary mt-4">Guardar Nuevo Producto</button>
        <a href="../../views/admin.php" class="btn btn-danger mt-4">Regresar</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
