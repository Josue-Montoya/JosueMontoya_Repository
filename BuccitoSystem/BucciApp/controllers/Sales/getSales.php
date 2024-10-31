<?php
// controllers/Sales/getSales.php
include '../../conf/conf.php';

try {
    $query = "
        SELECT id_venta, fecha_venta, total 
        FROM tbl_ventas 
        WHERE 1=1
    ";
    
    $params = [];
    
    // Agregar filtros de fecha si están presentes
    if (isset($_GET['from']) && !empty($_GET['from'])) {
        $query .= " AND DATE(fecha_venta) >= :from";
        $params['from'] = $_GET['from'];
    }
    
    if (isset($_GET['to']) && !empty($_GET['to'])) {
        $query .= " AND DATE(fecha_venta) <= :to";
        $params['to'] = $_GET['to'];
    }
    
    $query .= " ORDER BY fecha_venta DESC";
    
    $stmt = $connection->prepare($query);
    $stmt->execute($params);
    $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($ventas);
    
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}
