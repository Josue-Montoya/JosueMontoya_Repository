<?php
session_start();
if ($_SESSION['user'] == "" || $_SESSION['user'] != "administrador") {
    header("Location: ../../views/Buys/indexBuy.php");
    exit();
}

include '../../conf/conf.php';

if (isset($_GET['id'])) {
    $idCompra = $_GET['id'];

    // Obtener datos de la compra
    $query = "SELECT c.id_compra, c.cantidad, c.id_producto, p.nombreProducto 
              FROM tbl_compras AS c
              INNER JOIN tbl_productos AS p ON c.id_producto = p.id_producto
              WHERE c.id_compra = :idCompra";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':idCompra', $idCompra, PDO::PARAM_INT);
    $stmt->execute();
    $purchase = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$purchase) {
        header("Location: ../../views/Buys/indexBuy.php");
        exit();
    }
} else {
    header("Location: ../../views/Buys/indexBuy.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Editar Compra</h1>
    <form action="../../controllers/Buys/editBuyController.php" method="POST">
        <input type="hidden" name="id_compra" value="<?php echo $purchase['id_compra']; ?>">
        
        <div class="form-group">
            <label for="producto">Producto:</label>
            <input type="text" class="form-control" id="producto" value="<?php echo htmlspecialchars($purchase['nombreProducto']); ?>" disabled>
        </div>
        
        <div class="form-group">
            <label for="cantidad">Cantidad:</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?php echo $purchase['cantidad']; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Guardar Cambios</button>
        <a href="../../views/Buys/indexBuy.php" class="btn btn-danger mt-4">Cancelar</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
