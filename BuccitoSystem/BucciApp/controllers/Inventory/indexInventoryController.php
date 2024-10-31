<?php
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

include '../../conf/conf.php';

$query = "SELECT i.id_inventario, p.nombreProducto, i.existencias_actuales, 
                 i.descripcion, i.precio, i.ultima_transaccion, i.tipo_ultima_transaccion
          FROM tbl_inventario i
          JOIN tbl_productos p ON i.id_producto = p.id_producto
          WHERE p.nombreProducto LIKE :search";

try {
    $stmt = $connection->prepare($query);
    $searchParam = "%$search%";
    $stmt->bindParam(':search', $searchParam);
    $stmt->execute();
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener el inventario: " . $e->getMessage();
}
?>
