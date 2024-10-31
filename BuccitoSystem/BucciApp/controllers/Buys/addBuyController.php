<?php

include '../../conf/conf.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];

    $sql = "INSERT INTO tbl_compras (id_producto, cantidad) VALUES (:id_producto, :cantidad)";

    try {
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->execute();

        // Redirecciona a la página principal después de registrar la compra
        header("Location: ../../views/Buys/indexBuy.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al registrar la compra: " . $e->getMessage();
    }
}
?>
