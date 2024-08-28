<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
</head>
<body>
    <div class="container">
            <div class="card m-auto mt-5 p-4">
                <form action="ejercicio3.php" method="POST">
                    <h5 style="text-align: center;">Generador de triangulos</h5>
                    <div class="row justify-content-center mb-4"> 
                        <div class="col-md-4">
                            <label for="N1">Lado a:</label>
                            <input type="number" class="form-control" name="N1" id="N1">
                        </div>
                        <div class="col-md-4">
                            <label for="N2">Lado b:</label>
                            <input type="number" class="form-control" name="N2" id="N2">
                        </div>
                        <div class="col-md-4">
                            <label for="N3">Base:</label>
                            <input type="number" class="form-control" name="N3" id="N3">
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
                            $num1 = $_POST["N1"];
                            $num2 = $_POST["N2"];
                            $num3 = $_POST["N3"];
                            
                            if ($num1 == $num2 && $num2 == $num3 && $num3 == $num1) { 
                                echo "¡Es un triángulo equilátero!". "<br>";
                            }else if($num1 == $num2 || $num2 == $num3 || $num3 == $num1) {
                                echo "¡Es un triángulo isóceles!". "<br>";
                            }else if ($num1 != $num2 && $num2 != $num3 && $num3 != $num1) { 
                                echo "¡Es un triángulo escaleno!". "<br>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>