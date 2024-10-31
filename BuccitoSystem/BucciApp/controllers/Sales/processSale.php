<?php
include '../../conf/conf.php';

header('Content-Type: application/json');

try {
    // Validar que se recibieron datos
    if (!isset($_POST['cart']) || empty($_POST['cart'])) {
        throw new Exception('No se recibieron datos del carrito');
    }

    // Decodificar el carrito
    $cart = json_decode($_POST['cart'], true);
    if (!$cart) {
        throw new Exception('Error al decodificar el carrito');
    }

    $connection->beginTransaction();

    // Primero verificamos el inventario disponible
    foreach ($cart as $item) {
        $stmt = $connection->prepare("
            SELECT existencias_actuales 
            FROM tbl_inventario 
            WHERE id_producto = :id_producto
        ");
        $stmt->execute(['id_producto' => $item['productId']]);
        $inventario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$inventario) {
            throw new Exception("Producto no encontrado en inventario: {$item['name']}");
        }

        if ($inventario['existencias_actuales'] < $item['quantity']) {
            throw new Exception("Stock insuficiente para {$item['name']}. Disponible: {$inventario['existencias_actuales']}");
        }
    }

    // Calcular el total
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Insertar la venta
    $stmt = $connection->prepare("
        INSERT INTO tbl_ventas (total, fecha_venta) 
        VALUES (:total, CURRENT_TIMESTAMP)
    ");
    $stmt->execute(['total' => $total]);
    $ventaId = $connection->lastInsertId();

    // Insertar los detalles y actualizar inventario
    $stmtDetalle = $connection->prepare("
        INSERT INTO tbl_detalle_ventas (id_venta, id_producto, cantidad, precio)
        VALUES (:id_venta, :id_producto, :cantidad, :precio)
    ");

    foreach ($cart as $item) {
        // Insertar detalle de venta
        $stmtDetalle->execute([
            'id_venta' => $ventaId,
            'id_producto' => $item['productId'],
            'cantidad' => $item['quantity'],
            'precio' => $item['price']
        ]);
    }

    $connection->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Venta procesada correctamente',
        'ventaId' => $ventaId
    ]);

} catch (Exception $e) {
    if ($connection->inTransaction()) {
        $connection->rollBack();
    }
    
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}