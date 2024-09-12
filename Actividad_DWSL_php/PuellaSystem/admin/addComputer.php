<?php
session_start();
if ($_SESSION["user"] == "") {
    header("Location: ./index.php");
}
include_once("../conf/conf.php");

$query = "SELECT BrandID, BrandName FROM tbl_Brand";
$brands = mysqli_query($con, $query);

if (!$brands) {
    die("Error en la consulta: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/addComputer.css">
    <title>Agregar Computadoras</title>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Agregando Computadora</h2>
        <form action="computerControls.php" method="POST">
            <div class="form-group">
                <input type="text" name="theFlag" value="1" hidden>
                <input class="form-control" type="text" name="name" placeholder="Nombre" required><br>
                
                <select class="form-control" name="brand" required>
                    <option value="" disabled selected>Seleccione una marca</option>
                    <?php
                    while ($row = mysqli_fetch_array($brands)) {
                        echo "<option value='" . $row['BrandID'] . "'>" . $row['BrandName'] . "</option>";
                    }
                    ?>
                </select><br>
                
                <input class="form-control" type="number" name="stock" placeholder="Stock" required><br>
                
                <div class="button-container">
                    <button class="btn btn-primary btn-custom" type="submit">Guardar</button>
                    <a href="index.php" class="btn btn-salir">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
