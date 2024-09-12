<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ex II</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="card m-auto mt-3 p-4">
            <div class="row justify-content-center">    
                <h5 style="text-align: center;">Ejemplo de bucle for.</h5>
                <p style="text-align: center;">Números pares del 1 al 200 excepto los que están entre 50 y 125</p>
                <div class="col-md-6" style="text-align: center;">
                    <?php
                        for ($i = 1; $i <= 200; $i++) {
                            if ($i >= 50 && $i <= 125) {
                                continue;
                            }else{
                                if ($i % 2 == 0) {
                                    echo"$i <br>";
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>