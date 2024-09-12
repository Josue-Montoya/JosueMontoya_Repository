<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Ejercicio 1</title>
</head>
<body>
    <div class="container">
            <div class="card m-auto mt-5 p-4">
                <form action="Ejercicio1.php" method="POST">
                    <div class="row justify-content-center mb-4">
                        <div class="col-md-4">
                            <label for="N1">Número 1:</label>
                            <input type="text" class="form-control" name="N1" id="N1">
                        </div>
                        <div class="col-md-4">
                            <label for="N2">Número 2:</label>
                            <input type="text" class="form-control" name="N2" id="N2">
                        </div>
                        <div class="col-md-4">
                            <label for="N3">Número 3:</label>
                            <input type="text" class="form-control" name="N3" id="N3">
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-4 text-center">
                            <button type="submit" class="btn btn-success">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</body>
</html>

<?php
    $num1 = $_POST["N1"];
    $num2 = $_POST["N2"];
    $num3 = $_POST["N3"];

    if($num1 > $num2 && $num1 > $num3){
        $numMayor = $num1;
    }
    elseif($num2 > $num1 && $num2 > $num3){
        $numMayor = $num2;
    }
    elseif($num3 > $num1 && $num3 > $num2){
        $numMayor = $num3;
    }
    elseif($num1 == $num2 && $num1 == $num3){
        $numMayor = "Los 3 numeros son iguales";
    }

    echo "<br></br>";
    echo "El numero mayor es: $numMayor";
?>