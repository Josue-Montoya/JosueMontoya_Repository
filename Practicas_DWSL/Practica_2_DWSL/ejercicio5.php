<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 5</title>
</head>
<body>
    <div class="container">
            <div class="card m-auto mt-5 p-4">
                <form action="ejercicio5.php" method="POST">
                    <h5 style="text-align: center;">Calculador de bonos.</h5>
                    <div class="row justify-content-center mb-4"> 
                        <div class="col-md-4">
                            <label for="N1">Nombre del empleado:</label>
                            <input type="text" class="form-control" name="name" id="anme">
                        </div>
                        <div class="col-md-4">
                            <label for="N2">Años trabajados:</label>
                            <input type="number" class="form-control" name="years" id="years">
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-4 text-center">
                            <button type="submit" class="btn btn-success">Calcular el bono</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card m-auto mt-3 p-4">
                <div class="row justify-content-center">
                    <div class="col-md-6" style="text-align: center;">
                        <?php
                            $name = $_POST["name"];
                            $years = $_POST["years"];
                            $bono = "";

                            if ($years >= 0 && $years < 2) {
                                $bono = "<br> ¡Han sido menos de dos anios trabajados, no califica para el bono";
                            } else if ($years >= 2 && $years < 3) {
                                $bono = "¡$500 Dólares!";
                            }else if ($years >= 3 && $years < 5) {
                                $bono = "¡$700 Dólares!";
                            }else if ($years >= 5 && $years < 10) {
                                $bono = "¡$1,000 Dólares!";
                            }else if ($years >= 10) {
                                $bono = "¡$2,000 Dólares!";
                            }

                            echo "El empleado $name tiene un bono de: $bono";
                        ?>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>