<?php

include '../../conf/conf.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreProducto = $_POST['nombreProducto'];
    $descripcion = $_POST['descripcion'];
    $precioUnitario = $_POST['precioUnitario'];

    $sql = "INSERT INTO tbl_productos (nombreProducto, descripcion, precioUnitario)
            VALUES (:nombreProducto, :descripcion, :precioUnitario)";

    try {
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':nombreProducto', $nombreProducto);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precioUnitario', $precioUnitario);
        $stmt->execute();

        // Redirecciona a la página de productos después de agregar el nuevo producto
        header("Location: ../../views/admin.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al crear el producto: " . $e->getMessage();
    }
}
?>
