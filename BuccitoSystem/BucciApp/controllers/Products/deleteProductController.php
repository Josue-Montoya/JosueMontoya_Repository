<?php
include '../../conf/conf.php';

try {
    // Verifica que se haya recibido el ID del producto
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_producto'])) {
        $idProducto = $_POST['id_producto'];

        // Elimina el producto por su ID
        $sql = "DELETE FROM tbl_productos WHERE id_producto = :idProducto";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
        $stmt->execute();

        // Redirige a la lista de productos tras la eliminación
        header("Location: ../../views/admin.php");
        exit();
    } else {
        throw new Exception("ID de producto no proporcionado.");
    }
} catch (PDOException $e) {
    echo "Error al eliminar el producto: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
