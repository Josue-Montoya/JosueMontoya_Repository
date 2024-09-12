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
        <div class="card m-auto mt-3 p-4">
            <div class="row justify-content-center">    
                <h5 style="text-align: center;">Ejemplo de bucle While.</h5>
                <p style="text-align: center;">Cuenta regresiva del 100 al 20.</p>
                <div class="col-md-6" style="text-align: center;">
                    <?php
                        $num = 100;
                        while ($num >= 20) {
                            echo "$num <br>";
                            $num--;
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>