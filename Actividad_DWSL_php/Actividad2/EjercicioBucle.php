<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablas de Multiplicar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Tablas de Multiplicar</h1>
        
        <form method="post" class="mb-4">
            <div class="row align-items-end">
                <div class="col-auto">
                    <label for="numero" class="form-label">Seleccione un número del 1 al 12:</label>
                    <select name="numero" id="numero" class="form-select">
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                            echo "<option value=\"$i\">$i</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Mostrar tabla</button>
                </div>
            </div>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['numero'])) {
            $numero = intval($_POST['numero']);
            if ($numero >= 1 && $numero <= 12) {
                echo "<h2>Tabla de multiplicar del $numero</h2>";
                echo "<div class='table-responsive'>";
                echo "<table class='table table-striped table-bordered'>";
                echo "<thead class='table-dark'><tr><th>Multiplicación</th><th>Resultado</th></tr></thead>";
                echo "<tbody>";
                for ($i = 1; $i <= 12; $i++) {
                    $resultado = $numero * $i;
                    echo "<tr><td>$numero x $i</td><td>$resultado</td></tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
            } else {
                echo "<div class='alert alert-danger'>Por favor, seleccione un número del 1 al 12.</div>";
            }
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>