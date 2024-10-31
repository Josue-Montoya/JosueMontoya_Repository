<?php
include '../../conf/conf.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idProducto = $_POST['id_producto'];
    $nombreProducto = $_POST['nombreProducto'];
    $descripcion = $_POST['descripcion'];
    $precioUnitario = $_POST['precioUnitario'];

    $sql = "UPDATE tbl_productos 
            SET nombreProducto = :nombreProducto, descripcion = :descripcion, precioUnitario = :precioUnitario 
            WHERE id_producto = :idProducto";

    try {
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':nombreProducto', $nombreProducto);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precioUnitario', $precioUnitario);
        $stmt->bindParam(':idProducto', $idProducto);
        
        $stmt->execute();

        header("Location: ../../views/admin.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al actualizar el producto: " . $e->getMessage();
    }
}
?>
