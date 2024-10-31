<?php
include '../../conf/conf.php';

try {
    // Verifica que se hayan pasado los parámetros necesarios
    if (!isset($_GET['id']) || !isset($_GET['action'])) {
        throw new Exception("Faltan parámetros requeridos.");
    }

    $idCompra = $_GET['id'];
    $action = $_GET['action'];

    // Consulta para obtener los detalles de la compra por su ID
    $sql = "SELECT 
                c.id_compra, 
                p.nombreProducto AS producto,
                c.cantidad, 
                c.fecha_compra, 
                c.id_producto 
            FROM 
                tbl_compras AS c
            INNER JOIN 
                tbl_productos AS p ON c.id_producto = p.id_producto
            WHERE 
                c.id_compra = :idCompra";

    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':idCompra', $idCompra, PDO::PARAM_INT);
    $stmt->execute();
    $purchase = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$purchase) {
        throw new Exception("No se encontró la compra.");
    }

    // Selección de vista según la acción
    if ($action == 'edit') {
        include '../../views/Buys/editBuyById.php';
    } else if ($action == 'delete') {
        include '../../views/Buys/deleteBuy.php';
    } else {
        throw new Exception("Acción no válida.");
    }
} catch (PDOException $e) {
    echo "Error al obtener la compra: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
