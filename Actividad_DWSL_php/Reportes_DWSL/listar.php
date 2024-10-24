<?php
require "../Reportes_DWSL/dompdf/autoload.inc.php";
include 'conf.php';

$connection = new Connection();
$conn = $connection->getConnection();

$opcion = isset($_POST['opcion']) ? $_POST['opcion'] : null;

$producto = isset($_POST['producto']) ? $_POST['producto'] : null;
$proveedor = isset($_POST['proveedor']) ? $_POST['proveedor'] : null;
$fechaVencimiento = isset($_POST['vencimiento']) ? $_POST['vencimiento'] : null;


$reports = [];

if ($opcion == 1) {
    $query = "CALL sp_FiltrarPorNombreProducto(:producto);";
    $result = $conn->prepare($query);
    $result->bindParam("producto", $producto);
    $result->execute();
    $reports = $result->fetchAll(PDO::FETCH_ASSOC);
} elseif ($opcion == 2) {
    $query = "CALL sp_FiltrarPorProveedor(:proveedor);";
    $result = $conn->prepare($query);
    $result->bindParam("proveedor", $proveedor);
    $result->execute();
    $reports = $result->fetchAll(PDO::FETCH_ASSOC);
} elseif ($opcion == 3) {
    $query = "CALL sp_FiltrarPorFechaVencimiento(:fechaVencimiento);";
    $result = $conn->prepare($query);
    $result->bindParam("fechaVencimiento", $fechaVencimiento);
    $result->execute();
    $reports = $result->fetchAll(PDO::FETCH_ASSOC);
}

include 'index.html';
?>