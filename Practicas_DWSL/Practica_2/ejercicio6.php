<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6</title>
</head>
<body>
    <div class="container">
            <div class="card m-auto mt-5">
                <form action="ejercicio6.php" method="POST">
                    <div class="row m-5 justify-content-center">
                        <div class="col-md-4">
                            <label for="">Nombre empleado:</label>
                            <input type="text" class="form-control" name="txtName">
                        </div>
                        <div class="col-md-4">
                            <label for="">Cantidad vendida:</label>
                            <input type="text" class="form-control" name="txtSold">
                        </div>
                        <div class="row justify-content-center mb-4">
                            <div class="col-md-4">
                                <button class="btn btn-success">Enviar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</body>
</html>

<?php
    $nombre = $_POST["txtName"];
    $cantidad = $_POST["txtSold"];
    $comision = 0;
    $salario = 850;

    if ($cantidad >= 10000 && $cantidad < 12000) {
        $comision = $cantidad * 0.03;
    }else if ($cantidad >= 12000 && $cantidad < 15000) {
        $comision = $cantidad * 0.05;
    }else if ($cantidad >= 15000) {
        $comision = $cantidad * 0.10;
    }

    echo "<br><br>";
    echo "Empleado: $nombre <br>";
    echo "Comisión obtenida: $comision <br>";
    echo "Total pago: ". ($salario + $comision);
?>