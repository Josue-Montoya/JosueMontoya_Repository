<!-- views/sales/salesHistory.php -->
<?php
session_start();
if ($_SESSION['user'] == "") {
    header("Location: ../../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bucci - Historial de Ventas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../../css/styles.css">
</head>

<body class="sb-nav-fixed">
    <!-- Navegación -->
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
                                <a class="nav-link" href="../../views/inventory/indexInventory.php">Ver Inventario</a>
                                <a class="nav-link" href="../../views/Sales/indexSales.php">Ventas</a>
                                <a class="nav-link" href="../../views/Sales/salesHistory.php">Historial de Ventas</a>
                                <?php if ($_SESSION['user'] == "administrador"): ?>
                                    <a class="nav-link" href="../../views/Graphics/salesAnalytics.php">Análisis de Ventas</a>
                                    <a class="nav-link" href="../../views/Buys/indexBuy.php">Entrada de Productos</a>
                                    <a class="nav-link" href="../../views/admin.php">Crear Productos</a>
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
                    <h1 class="mt-4">Historial de Ventas</h1>

                    <!-- Filtros -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="dateFrom" class="form-label">Desde:</label>
                                    <input type="date" class="form-control" id="dateFrom">
                                </div>
                                <div class="col-md-4">
                                    <label for="dateTo" class="form-label">Hasta:</label>
                                    <input type="date" class="form-control" id="dateTo">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">&nbsp;</label>
                                    <button class="btn btn-primary d-block" id="filterSales">Filtrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Ventas -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Ventas Realizadas
                        </div>
                        <div class="card-body">
                            <table id="salesTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID Venta</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal de Detalles -->
                <div class="modal fade" id="saleDetailsModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detalles de la Venta</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="saleDetailsBody">
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                            <td id="modalTotal"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="../../js/scripts.js"></script>
    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            let table = $('#salesTable').DataTable({
                ajax: {
                    url: '../../controllers/Sales/getSales.php',
                    dataSrc: ''
                },
                columns: [{
                        data: 'id_venta'
                    },
                    {
                        data: 'fecha_venta',
                        render: function(data) {
                            return new Date(data).toLocaleString();
                        }
                    },
                    {
                        data: 'total',
                        render: function(data) {
                            return '$' + parseFloat(data).toFixed(2);
                        }
                    },
                    {
                        data: 'id_venta',
                        render: function(data) {
                            return `
                        <button class="btn btn-info btn-sm view-details" data-id="${data}">
                            <i class="fas fa-eye"></i> Ver Detalles
                        </button>
                    `;
                        }
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
                }
            });

            // Manejador para el botón de filtrar
            $('#filterSales').click(function() {
                let dateFrom = $('#dateFrom').val();
                let dateTo = $('#dateTo').val();

                table.ajax.url('../../controllers/Sales/getSales.php?from=' + dateFrom + '&to=' + dateTo).load();
            });

            // Ver detalles de venta
            $(document).on('click', '.view-details', function() {
                let saleId = $(this).data('id');

                $.ajax({
                    url: '../../controllers/Sales/getSaleDetails.php',
                    method: 'GET',
                    data: {
                        id: saleId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            let details = response.data;
                            let tbody = $('#saleDetailsBody');
                            tbody.empty();
                            let total = 0;

                            details.forEach(function(item) {
                                let subtotal = parseFloat(item.subtotal);
                                total += subtotal;
                                tbody.append(`
                            <tr>
                                <td>${item.nombreProducto}</td>
                                <td>${item.cantidad}</td>
                                <td>$${parseFloat(item.precio).toFixed(2)}</td>
                                <td>$${subtotal.toFixed(2)}</td>
                            </tr>
                        `);
                            });

                            $('#modalTotal').text('$' + total.toFixed(2));
                            $('#saleDetailsModal').modal('show');
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error al cargar los detalles de la venta: ' + error);
                        console.error('Error en la solicitud:', xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>

</html>