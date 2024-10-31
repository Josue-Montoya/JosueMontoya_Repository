<?php
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

include '../../conf/conf.php';

$sql = "SELECT c.id_compra, p.nombreProducto AS producto, c.cantidad, c.fecha_compra
        FROM tbl_compras AS c
        INNER JOIN tbl_productos AS p ON c.id_producto = p.id_producto";
        

try {
    $stmt = $connection->prepare($sql);
    if (!empty($search)) {
        $searchParam = "%$search%";
        $stmt->bindParam(':search', $searchParam);
    }
    $stmt->execute();
    $purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener la lista de compras: " . $e->getMessage();
}
?>
