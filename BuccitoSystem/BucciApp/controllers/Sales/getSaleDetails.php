<?php
// controllers/Sales/getSaleDetails.php
include '../../conf/conf.php';

header('Content-Type: application/json');

try {
    if (!isset($_GET['id'])) {
        throw new Exception('ID de venta no proporcionado');
    }
    
    $query = "
        SELECT 
            dv.id_detalle,
            dv.cantidad,
            dv.precio,
            dv.subtotal,
            p.nombreProducto,
            v.fecha_venta,
            v.total as total_venta
        FROM tbl_detalle_ventas dv
        JOIN tbl_productos p ON dv.id_producto = p.id_producto
        JOIN tbl_ventas v ON dv.id_venta = v.id_venta
        WHERE dv.id_venta = :id_venta
        ORDER BY dv.id_detalle
    ";
    
    $stmt = $connection->prepare($query);
    $stmt->execute(['id_venta' => $_GET['id']]);
    $detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($detalles)) {
        throw new Exception('No se encontraron detalles para esta venta');
    }
    
    echo json_encode([
        'success' => true,
        'data' => $detalles
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}