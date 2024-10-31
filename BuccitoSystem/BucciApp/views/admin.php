<?php
session_start();
if ($_SESSION['user'] == "" || $_SESSION['user'] != "administrador") {
    header("Location: ../../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bucci - Dashboard</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../css/styles.css">
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
                    <li><a class="dropdown-item" href="../controllers/logout.php">Cerrar Sesión</a></li>
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
                                <a class="nav-link" href="./Sales/indexSales.php">Ventas</a>
                                <a class="nav-link" href="./Sales/salesHistory.php">Historial de Ventas</a>
                                <a class="nav-link" href="./inventory/indexInventory.php">Ver Inventario</a>
                                <?php if ($_SESSION['user'] == "administrador"): ?>
                                    <a class="nav-link" href="./admin.php">Crear Productos</a>
                                    <a class="nav-link" href="./Buys/indexBuy.php">Entrada de Productos</a>
                                    <a class="nav-link" href="./Graphics/salesAnalytics.php">Análisis de Ventas</a>
                                    <a class="nav-link" href="./users/indexUser.php">Gestionar Usuarios</a>
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
                    <h1 class="mt-4">Lista de Productos</h1>
                    <div class="table-actions mb-3">
                        <div id="tableButtons"></div>
                        <div id="tableSearch" class="float-end"></div>
                        <?php if ($_SESSION["user"] == "administrador") { ?>
                            <a href="../views/products/addProduct.php" class="btn btn-success">
                                <i class="fas fa-plus"></i> Crear Nuevo Producto
                            </a>
                        <?php } ?>
                    </div>

                    <table class="table table-striped table-bordered" id="productTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre del Producto</th>
                                <th>Descripción</th>
                                <th>Precio Unitario</th>
                                <?php if ($_SESSION["user"] == "administrador") { ?>
                                    <th>Acciones</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../controllers/Products/IndexProductController.php';
                            foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo $product['id_producto']; ?></td>
                                    <td><?php echo $product['nombreProducto']; ?></td>
                                    <td><?php echo $product['descripcion']; ?></td>
                                    <td><?php echo "$" . number_format($product['precioUnitario'], 2); ?></td>
                                    <?php if ($_SESSION["user"] == "administrador") { ?>
                                        <td>
                                            <a href="../controllers/Products/getProductById.php?action=edit&id=<?php echo $product['id_producto']; ?>"
                                                class="btn btn-primary btn-action">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="../controllers/Products/getProductById.php?action=delete&id=<?php echo $product['id_producto']; ?>"
                                                class="btn btn-danger btn-action"
                                                onclick="return confirm('¿Está seguro de eliminar este producto?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    <?php } ?>
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
            var table = $('#productTable').DataTable({
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
                    searchPlaceholder: "Buscar productos...",
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
                pageLength: 10,
                initComplete: function() {
                    // Mover los botones y la búsqueda a los contenedores personalizados
                    $('.dt-buttons').detach().appendTo('#tableButtons');
                    $('.dataTables_filter').detach().appendTo('#tableSearch');
                }
            });
        });

        // Toggle del sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function(e) {
            e.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
        });
    </script>


</body>

</html>