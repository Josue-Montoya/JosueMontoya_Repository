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
    <title>Eliminar Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Eliminar Compra</h1>
    <p>¿Estás seguro de que deseas eliminar la siguiente compra?</p>
    <ul>
        <li><strong>ID de Compra:</strong> <?php echo htmlspecialchars($purchase['id_compra']); ?></li>
        <li><strong>Producto:</strong> <?php echo htmlspecialchars($purchase['nombreProducto']); ?></li>
        <li><strong>Cantidad:</strong> <?php echo htmlspecialchars($purchase['cantidad']); ?></li>
    </ul>

    <form action="../../controllers/Buys/deleteBuyController.php" method="POST">
        <input type="hidden" name="id_compra" value="<?php echo htmlspecialchars($purchase['id_compra']); ?>">
        <button type="submit" class="btn btn-danger">Eliminar</button>
        <a href="../../views/Buys/indexBuy.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
