<?php
    require_once 'Negocio/categorias.php';
    require_once 'Negocio/productos.php';

    $productos = new Productos();
    $categorias = new Categorias();
?>

<div class="card m-auto mt-5 p-3" style="width: 600px;">
    <h3>Agregar producto</h3>
    <form method="POST" action="">
        <div class="row">
            <div class="col-3">
                <button type="button" onClick="location.replace('index.php?mod=&form=li');" class="btn btn-danger">Cancelar</button>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-5">
                <label for="">Nombre:</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="col-5">
                <label for="">Categoria:</label>
                <select class="form-control" name="categorie">
                    <?php
                    foreach ($categorias->list_categories() as $categoria) {
                        ?>
                        <option value="<?= $categoria['id']; ?>">
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
                <label for="">Descripción:</label>
                <textarea class="form-control" name="description"></textarea>
            </div>
        </div>
        <div class="row mt-3 ms-5 mb-3">
            <div class="col-3">
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
        </div>
    </form>
</div>

<?php
    if ($_SERVER["REQUEST_METHOD"] = "POST") {
        $productos->name = $_POST["name"];
        $productos->description = $_POST["description"];
        $productos->categorie = $_POST["categorie"];
        //ejecutamos el mantenimiento de agregar
        if ($productos->add()){
            echo "<script>location.replace('index.php?mod=&form=li')</script>";
        }else{
            echo "error";
        }
    }
?>