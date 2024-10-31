<?php
include '../../conf/conf.php';

try {
    // Verifica que se hayan pasado los parámetros necesarios
    if (!isset($_GET['id']) || !isset($_GET['action'])) {
        throw new Exception("Faltan parámetros requeridos.");
    }

    $idProducto = $_GET['id'];
    $action = $_GET['action'];

    // Consulta para obtener los detalles del producto por su ID
    $sql = "SELECT 
                id_producto, 
                nombreProducto, 
                descripcion, 
                precioUnitario 
            FROM 
                tbl_productos 
            WHERE 
                id_producto = :idProducto";

    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        throw new Exception("No se encontró el producto.");
    }

    // Selección de vista según la acción
    if ($action == 'edit') {
        include '../../views/products/editProduct.php';
    } else if ($action == 'delete') {
        include '../../views/products/deleteProduct.php';
    } else {
        throw new Exception("Acción no válida.");
    }
} catch (PDOException $e) {
    echo "Error al obtener el producto: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
