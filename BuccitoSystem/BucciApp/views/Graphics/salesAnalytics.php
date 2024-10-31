<?php
session_start();
if ($_SESSION['user'] == "" || $_SESSION['user'] != "administrador") {
    header("Location: ../../index.php");
    exit();
}

include '../../conf/conf.php';

// Consulta optimizada para productos más vendidos
$queryTopSales = "
    SELECT 
        p.nombreProducto,
        SUM(dv.cantidad) as total_vendido,
        SUM(dv.subtotal) as total_ingresos
    FROM tbl_productos p
    INNER JOIN tbl_detalle_ventas dv ON p.id_producto = dv.id_producto
    INNER JOIN tbl_ventas v ON dv.id_venta = v.id_venta
    GROUP BY p.id_producto, p.nombreProducto
    HAVING total_vendido > 0
    ORDER BY total_vendido DESC
    LIMIT 10
";

// Consultas para ventas por mes y ventas diarias
$queryMonthlySales = "
    SELECT 
        DATE_FORMAT(v.fecha_venta, '%Y-%m') as periodo,
        SUM(dv.subtotal) as total_ventas,
        COUNT(DISTINCT v.id_venta) as numero_ventas
    FROM tbl_ventas v
    JOIN tbl_detalle_ventas dv ON v.id_venta = dv.id_venta
    GROUP BY DATE_FORMAT(v.fecha_venta, '%Y-%m')
    ORDER BY periodo DESC
    LIMIT 12
";

$queryDailySales = "
    SELECT 
        DATE_FORMAT(v.fecha_venta, '%Y-%m-%d') as periodo,
        SUM(dv.subtotal) as total_ventas,
        COUNT(DISTINCT v.id_venta) as numero_ventas
    FROM tbl_ventas v
    JOIN tbl_detalle_ventas dv ON v.id_venta = dv.id_venta
    GROUP BY DATE_FORMAT(v.fecha_venta, '%Y-%m-%d')
    ORDER BY periodo DESC
    LIMIT 30
";

// Consulta para inventario bajo
$queryLowStock = "
    SELECT 
        p.nombreProducto,
        i.existencias_actuales
    FROM tbl_productos p
    JOIN tbl_inventario i ON p.id_producto = i.id_producto
    WHERE i.existencias_actuales < 10
    ORDER BY i.existencias_actuales ASC
";

try {
    // Ejecutar consultas
    $stmtTopSales = $connection->query($queryTopSales);
    $topSales = $stmtTopSales->fetchAll(PDO::FETCH_ASSOC);

    $stmtMonthlySales = $connection->query($queryMonthlySales);
    $monthlySales = $stmtMonthlySales->fetchAll(PDO::FETCH_ASSOC);

    $stmtDailySales = $connection->query($queryDailySales);
    $dailySales = $stmtDailySales->fetchAll(PDO::FETCH_ASSOC);

    $stmtLowStock = $connection->query($queryLowStock);
    $lowStock = $stmtLowStock->fetchAll(PDO::FETCH_ASSOC);

    // Convertir los datos a JSON
    $topSalesJSON = json_encode($topSales);
    $monthlySalesJSON = json_encode($monthlySales);
    $dailySalesJSON = json_encode($dailySales);
} catch (PDOException $e) {
    echo "Error al obtener datos: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bucci - Análisis de Ventas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/styles.css">
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark">
        <a class="navbar-brand ps-3" href="#">Bucci</a>
        <button class="btn btn-link btn-sm order-lg-0 me-4 me-lg-0" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <ul class="navbar-nav ms-auto me-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#">Configuración</a></li>
                    <li><a class="dropdown-item" href="#">Registro de Actividad</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="../../controllers/logout.php">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Buccito System</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Menu
                            <div class="ms-auto">
                                <i class="fas fa-angle-down"></i>
                            </div>
                        </a>
                        <div class="collapse" id="collapseLayouts" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="../../views/Sales/indexSales.php">Ventas</a>
                                <a class="nav-link" href="../../views/Sales/salesHistory.php">Historial de Ventas</a>
                                <a class="nav-link" href="../../views/inventory/indexInventory.php">Ver Inventario</a>
                                <?php if ($_SESSION['user'] == "administrador"): ?>
                                    <a class="nav-link" href="../../views/admin.php">Crear Productos</a>
                                    <a class="nav-link" href="../../views/Buys/indexBuy.php">Entrada de Productos</a>
                                    <a class="nav-link" href="../../views/Graphics/salesAnalytics.php">Análisis de Ventas</a>
                                    <a class="nav-link" href="../../views/users/indexUser.php">Gestionar Usuarios</a>
                                <?php endif; ?>
                            </nav>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Análisis de Ventas</h1>

                    <div class="row">
                        <!-- Gráfico de Productos Más Vendidos -->
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Productos Más Vendidos
                                </div>
                                <div class="card-body">
                                    <canvas id="topProductsChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Gráfico de Ventas -->
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-line me-1"></i>
                                    Ventas
                                    <select id="salesInterval" class="form-select form-select-sm w-auto ms-2">
                                        <option value="monthly" selected>Mensual</option>
                                        <option value="daily">Diario</option>
                                    </select>
                                </div>
                                <div class="card-body">
                                    <canvas id="salesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alerta de Inventario Bajo -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Alertas de Inventario Bajo
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Existencias</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($lowStock as $item): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($item['nombreProducto']); ?></td>
                                                        <td><?php echo $item['existencias_actuales']; ?></td>
                                                        <td>
                                                            <?php if ($item['existencias_actuales'] <= 5): ?>
                                                                <span class="badge bg-danger">Crítico</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-warning">Bajo</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </main>
    </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Datos en formato JSON
        const topSalesData = <?php echo $topSalesJSON; ?>;
        const monthlySalesData = <?php echo $monthlySalesJSON; ?>;
        const dailySalesData = <?php echo $dailySalesJSON; ?>;

        // Gráfico de Productos Más Vendidos
        const topProductsChart = new Chart(document.getElementById('topProductsChart'), {
            type: 'bar',
            data: {
                labels: topSalesData.map(item => item.nombreProducto),
                datasets: [{
                    label: 'Cantidad Vendida',
                    data: topSalesData.map(item => item.total_vendido),
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad'
                        }
                    }
                }
            }
        });

        // Gráfico de Ventas (con opción de intervalo)
        let salesChart;
        const salesChartConfig = {
            type: 'line',
            data: {
                labels: monthlySalesData.map(item => item.periodo),
                datasets: [{
                    label: 'Total de Ventas',
                    data: monthlySalesData.map(item => item.total_ventas),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Monto en $'
                        }
                    }
                }
            }
        };

        // Crear gráfico inicial (Mensual)
        function createSalesChart() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            salesChart = new Chart(ctx, salesChartConfig);
        }

        // Cambiar intervalo del gráfico de ventas
        document.getElementById('salesInterval').addEventListener('change', function() {
            salesChart.destroy();
            const interval = this.value;

            if (interval === 'daily') {
                salesChartConfig.data.labels = dailySalesData.map(item => item.periodo);
                salesChartConfig.data.datasets[0].data = dailySalesData.map(item => item.total_ventas);
            } else {
                salesChartConfig.data.labels = monthlySalesData.map(item => item.periodo);
                salesChartConfig.data.datasets[0].data = monthlySalesData.map(item => item.total_ventas);
            }
            createSalesChart();
        });

        createSalesChart();
    </script>
</body>

</html>