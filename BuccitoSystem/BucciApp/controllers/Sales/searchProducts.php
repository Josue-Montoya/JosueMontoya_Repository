<?php
include '../../conf/conf.php';

$search = $_POST['search'] ?? '';
$query = "SELECT id_producto, nombreProducto, descripcion, precioUnitario 
          FROM tbl_productos 
          WHERE nombreProducto LIKE :search 
          OR descripcion LIKE :search";

try {
    $stmt = $connection->prepare($query);
    $searchParam = "%$search%";
    $stmt->bindParam(':search', $searchParam);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $output = '<div class="list-group">';
    foreach ($products as $product) {
        $output .= sprintf(
            '<a href="#" class="list-group-item list-group-item-action select-product" 
                data-id="%d" 
                data-name="%s" 
                data-price="%s">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">%s</h5>
                    <small class="text-primary">$%s</small>
                </div>
                <p class="mb-1">%s</p>
            </a>',
            $product['id_producto'],
            htmlspecialchars($product['nombreProducto']),
            $product['precioUnitario'],
            htmlspecialchars($product['nombreProducto']),
            number_format($product['precioUnitario'], 2),
            htmlspecialchars($product['descripcion'])
        );
    }
    $output .= '</div>';
    
    echo $output;
} catch (PDOException $e) {
    echo "Error al buscar productos: " . $e->getMessage();
}
?>