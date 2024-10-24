<?php
require "../Reportes_DWSL/dompdf/autoload.inc.php";
include 'conf.php';

use Dompdf\Dompdf;
$connection = new Connection();
$conn = $connection->getConnection();

$opcion = isset($_POST['opcion']) ? $_POST['opcion'] : null;

$producto = isset($_POST['producto']) ? $_POST['producto'] : null;
$proveedor = isset($_POST['proveedor']) ? $_POST['proveedor'] : null;
$fechaVencimiento = isset($_POST['fechaVencimiento']) ? $_POST['fechaVencimiento'] : null;

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

$html = '<div class="table-responsive" style="margin-top: 20px; padding: 10px; border: 1px solid #ccc; border-radius: 8px; background-color: #f9f9f9;">
            <table class="table table-striped table-bordered" style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif;">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="padding: 10px; text-align: center; background-color: #343a40; color: #fff;">ID</th>
                        <th scope="col" style="padding: 10px; text-align: center; background-color: #343a40; color: #fff;">Producto</th>
                        <th scope="col" style="padding: 10px; text-align: center; background-color: #343a40; color: #fff;">Proveedor</th>
                        <th scope="col" style="padding: 10px; text-align: center; background-color: #343a40; color: #fff;">Existencias</th>
                        <th scope="col" style="padding: 10px; text-align: center; background-color: #343a40; color: #fff;">Bodegas</th>
                        <th scope="col" style="padding: 10px; text-align: center; background-color: #343a40; color: #fff;">Precio</th>
                        <th scope="col" style="padding: 10px; text-align: center; background-color: #343a40; color: #fff;">Vencimiento</th>
                        <th scope="col" style="padding: 10px; text-align: center; background-color: #343a40; color: #fff;">Introducción</th>
                    </tr>
                </thead>
                <tbody>';

foreach ($reports as $report) {
    $html .= '<tr style="background-color: #ffffff; border-bottom: 1px solid #ddd;">
                <td style="padding: 10px; text-align: center;">' . htmlspecialchars($report['id']) . '</td>
                <td style="padding: 10px; text-align: center;">' . htmlspecialchars($report['producto']) . '</td>
                <td style="padding: 10px; text-align: center;">' . htmlspecialchars($report['proveedor']) . '</td>
                <td style="padding: 10px; text-align: center;">' . htmlspecialchars($report['existencias']) . '</td>
                <td style="padding: 10px; text-align: center;">' . htmlspecialchars($report['bodegas']) . '</td>
                <td style="padding: 10px; text-align: center;">' . htmlspecialchars($report['precio']) . '</td>
                <td style="padding: 10px; text-align: center;">' . htmlspecialchars($report['vencimiento']) . '</td>
                <td style="padding: 10px; text-align: center;">' . htmlspecialchars($report['introduccion']) . '</td>
              </tr>';
}

$html .= '        </tbody>
            </table>
        </div>';


$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$archivo = 'Reporte_' . date('Ymd_His') . '.pdf';
$dompdf->stream($archivo);

?>