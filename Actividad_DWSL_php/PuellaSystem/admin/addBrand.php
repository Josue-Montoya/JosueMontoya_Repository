<?php
session_start();
if ($_SESSION["user"] == "") {
    header("Location: ./index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/addBrand.css">
    <title>Agregar marcas</title>
</head>
<body>
    <div class="container">
        
        <h2 class="text-center mb-4">Agregando Marca</h2>
        
        <form action="brandControls.php" method="POST">
            <div class="form-group mb-4">
                <input type="text" name="theFlag" value="1" hidden>
                <input class="form-control mb-3" type="text" name="name" placeholder="Nombre" required>
            </div>
          
            <div class="button-container d-flex justify-content-between">
                <button class="btn btn-custom" type="submit">Guardar</button>
                <a href="brands.php" class="btn btn-salir">Salir</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
