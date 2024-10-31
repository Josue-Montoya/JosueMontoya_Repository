<!-- views/sales/indexSales.php -->
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
    <title>Bucci - Ventas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../../css/styles.css">
</head>

<body class="sb-nav-fixed">
    <!-- Mantén la misma estructura de navegación que tenías -->

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
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Nueva Venta</h1>

                    <!-- Formulario de Búsqueda de Productos -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" id="searchProduct" class="form-control" placeholder="Buscar producto...">
                                </div>
                            </div>
                            <div id="productResults" class="mt-3"></div>
                        </div>
                    </div>

                    <!-- Carrito de Compras -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-shopping-cart me-1"></i>
                            Carrito de Compras
                        </div>
                        <div class="card-body">
                            <table class="table" id="cartTable">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Subtotal</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                        <td id="totalAmount">$0.00</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <button class="btn btn-success" id="completeSale">Completar Venta</button>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            $(document).ready(function() {
                let cart = [];
                let selectedProduct = null;

                // Búsqueda de productos
                $('#searchProduct').on('keyup', function() {
                    let search = $(this).val();
                    if (search.length >= 2) {
                        $.ajax({
                            url: '../../controllers/Sales/searchProducts.php',
                            method: 'POST',
                            data: {
                                search: search
                            },
                            success: function(response) {
                                $('#productResults').html(response);
                            }
                        });
                    } else {
                        $('#productResults').html('');
                    }
                });

                // Cuando se selecciona un producto de la lista
                $(document).on('click', '.select-product', function(e) {
                    e.preventDefault();
                    let productId = $(this).data('id');
                    let productName = $(this).data('name');
                    let price = parseFloat($(this).data('price'));

                    // Verificar si el producto ya está en el carrito
                    let existingProduct = cart.find(item => item.productId === productId);
                    if (existingProduct) {
                        existingProduct.quantity++;
                    } else {
                        // Agregar nuevo producto al carrito
                        cart.push({
                            productId: productId,
                            name: productName,
                            price: price,
                            quantity: 1
                        });
                    }

                    // Actualizar la tabla del carrito
                    updateCartTable();

                    // Limpiar la búsqueda y resultados
                    $('#searchProduct').val('');
                    $('#productResults').html('');
                });

                // Actualizar carrito
                function updateCartTable() {
                    let tbody = $('#cartTable tbody');
                    tbody.empty();
                    let total = 0;

                    cart.forEach((item, index) => {
                        let subtotal = item.price * item.quantity;
                        total += subtotal;
                        tbody.append(`
                        <tr>
                            <td>${item.name}</td>
                            <td>
                                <input type="number" class="form-control quantity-input" 
                                    value="${item.quantity}" min="1" data-index="${index}"
                                    style="width: 80px;">
                            </td>
                            <td>$${item.price.toFixed(2)}</td>
                            <td>$${subtotal.toFixed(2)}</td>
                            <td>
                                <button class="btn btn-danger btn-sm remove-item" data-index="${index}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `);
                    });

                    $('#totalAmount').text(`$${total.toFixed(2)}`);
                }

                // Actualizar cantidad
                $(document).on('change', '.quantity-input', function() {
                    let index = $(this).data('index');
                    let newQuantity = parseInt($(this).val());
                    if (newQuantity > 0) {
                        cart[index].quantity = newQuantity;
                        updateCartTable();
                    }
                });

                // Eliminar item
                $(document).on('click', '.remove-item', function() {
                    let index = $(this).data('index');
                    cart.splice(index, 1);
                    updateCartTable();
                });

                // Completar venta
                $('#completeSale').click(function() {
                    if (cart.length === 0) {
                        alert('El carrito está vacío');
                        return;
                    }

                    // Deshabilitar el botón mientras se procesa
                    $(this).prop('disabled', true);

                    $.ajax({
                        url: '../../controllers/Sales/processSale.php',
                        method: 'POST',
                        data: {
                            cart: JSON.stringify(cart)
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                alert('Venta completada exitosamente');
                                // Limpiar carrito
                                cart = [];
                                updateCartTable();
                                // Opcional: Imprimir ticket o redirigir
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Error al procesar la venta: ' + error);
                        },
                        complete: function() {
                            // Rehabilitar el botón
                            $('#completeSale').prop('disabled', false);
                        }
                    });
                });
            });
        </script>
</body>

</html>