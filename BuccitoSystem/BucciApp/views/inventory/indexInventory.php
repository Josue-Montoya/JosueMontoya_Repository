<?php
session_start();
if ($_SESSION['user'] == "") {
    header("Location: ../../../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bucci - Inventario</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../../css/styles.css">
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark">
        <!-- Logo -->
        <a class="navbar-brand ps-3" href="#">Bucci</a>

        <!-- Sidebar Toggle -->
        <button class="btn btn-link btn-sm order-lg-0 me-4 me-lg-0" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Navbar-->
        <ul class="navbar-nav ms-auto me-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                <div class="container-fluid">
                    <h1 class="mt-4">Inventario de Productos</h1>

                    <table class="table table-striped table-bordered" id="inventoryTable">
                        <thead>
                            <tr>
                                <th>ID Inventario</th>
                                <th>Nombre del Producto</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Existencias Actuales</th>
                                <th>Última Transacción</th>
                                <th>Tipo Última Transacción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../../controllers/Inventory/indexInventoryController.php';
                            foreach ($inventory as $item): ?>
                                <tr>
                                    <td><?php echo $item['id_inventario']; ?></td>
                                    <td><?php echo $item['nombreProducto']; ?></td>
                                    <td><?php echo $item['descripcion']; ?></td>
                                    <td><?php echo $item['precio']; ?></td>
                                    <td><?php echo $item['existencias_actuales']; ?></td>
                                    <td><?php echo $item['ultima_transaccion']; ?></td>
                                    <td><?php echo $item['tipo_ultima_transaccion']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright © Bucci System 2024</div>
                        <div>
                            <a href="#" class="text-decoration-none">Política de Privacidad</a>
                            &middot;
                            <a href="#" class="text-decoration-none">Términos y Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script>
        $(document).ready(function() {
            $('#inventoryTable').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'csv',
                        className: 'btn btn-secondary',
                        text: 'CSV'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-secondary',
                        text: 'Excel'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-secondary',
                        text: 'PDF'
                    }
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Buscar en inventario...",
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    zeroRecords: "No se encontraron resultados",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    infoEmpty: "No hay registros disponibles",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                responsive: true,
                pageLength: 10
            });
        });

        document.getElementById('sidebarToggle').addEventListener('click', function(e) {
            e.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
        });
    </script>


</body>

</html>