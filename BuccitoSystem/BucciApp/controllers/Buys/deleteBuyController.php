<?php 
include '../../conf/conf.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCompra = $_POST['id_compra'];

    $sql = "DELETE FROM tbl_compras 
            WHERE id_compra = :idCompra";

    try {
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':idCompra', $idCompra, PDO::PARAM_INT);
        
        $stmt->execute();

        header("Location: ../../views/Buys/indexBuy.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al eliminar la compra: " . $e->getMessage();
    }
}
?>
