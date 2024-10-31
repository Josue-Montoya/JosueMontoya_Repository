<?php

$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

include '../conf/conf.php';

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
} catch (PDOException $e) {
    echo "Error al obtener la lista de productos: " . $e->getMessage();
}
?>