<?php
require_once "././Negocio/categorias.php";
require_once "././Negocio/productos.php";

$categorias = new Categorias();
$productos = new Productos();

$producto = $productos->get_producto($_GET['id'])[0]; 
?>

<div class="card m-auto mt-5 p-3" style="width: 600px;">
    <h3>Eliminar Producto</h3>
    <p>¿Estás seguro que deseas eliminar el siguiente producto? Esta acción no se puede deshacer.</p>
    
    <div class="row justify-content-center mt-4">
        <div class="col-5">
            <label>Nombre:</label>
            <input type="text" class="form-control" value="<?= $producto['name']; ?>" disabled>
        </div>
        <div class="col-5">
            <label>Categoría:</label>
            <select class="form-control" disabled>
                <?php
                foreach ($categorias->list_categories() as $categoria) {
                    $selected = ($categoria['id'] == $producto['id_categorie']) ? "selected" : "";
                    ?>
                    <option value="<?= $categoria['id']; ?>" <?= $selected; ?>>
                        <?= $categoria['name']; ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>

    <div class="row justify-content-center mt-3">
        <div class="col-10">
            <label>Descripción:</label>
            <textarea class="form-control" disabled><?= $producto['description']; ?></textarea>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-3">
            <button type="button" onclick="location.replace('index.php?mod=&form=li');" class="btn btn-secondary">Cancelar</button>
        </div>
        <div class="col-3">
            <form method="POST" action="">
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($productos->delete($_GET['id'])) {
        echo "<script>location.replace('index.php?mod=&form=li')</script>";
    } else {
        echo "Error al eliminar el producto.";
    }
}
?>
