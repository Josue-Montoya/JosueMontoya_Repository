<?php
include '../../conf/conf.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCompra = $_POST['id_compra'];
    $cantidad = $_POST['cantidad'];

    $sql = "UPDATE tbl_compras 
            SET cantidad = :cantidad
            WHERE id_compra = :idCompra";

    try {
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':idCompra', $idCompra, PDO::PARAM_INT);
        
        $stmt->execute();

        header("Location: ../../views/Buys/indexBuy.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al actualizar la compra: " . $e->getMessage();
    }
}
?>
