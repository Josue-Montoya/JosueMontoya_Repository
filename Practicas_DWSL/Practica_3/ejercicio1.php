<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ex III</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <form action="Ejercicio1.php" method="POST">
                <h5 style="text-align: center;">Generador de tableros.</h5>
                <div class="row justify-content-center mb-4"> 
                    <div class="col-md-4">
                        <label for="N1">Columnas:</label>
                        <input type="number" class="form-control" name="N1" id="N1">
                    </div>
                    <div class="col-md-4">
                        <label for="N2">Filas:</label>
                        <input type="number" class="form-control" name="N2" id="N2">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-4 text-center">
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card m-auto mt-3 p-4">
            <div class="row justify-content-center">
                <div class="col-md-6" style="text-align: center;">
                    <?php
                        $colums = $_POST["N1"];
                        $rows = $_POST["N2"];

                        echo "<table border='5'>";
                        for ($i = 1; $i <= $rows; $i++) {
                            echo "<tr>";
                            for ($j = 1; $j <= $colums; $j++) {
                                if (($i + $j) % 2 == 0) {
                                    echo "<td style='background-color: black; width: 50px; height: 50px;'></td>";
                                } else {
                                    echo "<td style='background-color: white; width: 50px; height: 50px;'></td>";
                                }
                            }
                            echo "</tr>";
                        }
                        echo "</table>";
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>