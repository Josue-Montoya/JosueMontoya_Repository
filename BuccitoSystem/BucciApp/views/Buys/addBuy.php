<?php
session_start();
if ($_SESSION['user'] == "" || $_SESSION['user'] != "administrador") {
    header("Location: ../../views/admin.php");
    exit();
}

include '../../controllers/Buys/addBuyController.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>

    <div class="container mt-5">
        <h1 class="mb-4">Registrar Nueva Compra</h1>
        <form action="../../controllers/Buys/addBuyController.php" method="POST">
            <div class="form-group">
                <label for="id_producto">Producto:</label>
                <select class="form-control" id="id_producto" name="id_producto" required>
                    <option value="" disabled selected>Selecciona un producto</option>
                    <?php
                    include '../../controllers/Products/IndexProductController.php';
                    foreach ($products as $producto): ?>
                        <option value="<?php echo $producto['id_producto']; ?>">
                            <?php echo $producto['nombreProducto']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Registrar Compra</button>
            <a href="../../views/Buys/indexBuy.php" class="btn btn-danger mt-4">Regresar</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>