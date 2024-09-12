<?php
include_once("../conf/conf.php");

$computerID = $_GET['computerID'];
$query = "SELECT C.computerName, C.computerStock, C.brandID 
          FROM tbl_Computers C 
          WHERE C.computerID = $computerID";
$result = mysqli_query($con, $query);
$computer = mysqli_fetch_assoc($result);

$query = "SELECT BrandID, BrandName FROM tbl_Brand";
$brands = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/editComputer.css">
    <title>Editar Computadora</title>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Editando Computadora</h2>
        <form action="computerControls.php" method="POST">
            <div class="form-group">
                <input type="text" name="theFlag" value="2" hidden>
                <input type="text" name="computerID" value="<?php echo $computerID; ?>" hidden>
                <input class="form-control" type="text" name="name" value="<?php echo $computer['computerName']; ?>" required><br>
                
                <select class="form-control" name="brand" required>
                    <option value="" disabled>Seleccione una marca</option>
                    <?php
                    while($row = mysqli_fetch_array($brands)) {
                        $selected = ($row['BrandID'] == $computer['brandID']) ? 'selected' : '';
                        echo "<option value='".$row['BrandID']."' $selected>".$row['BrandName']."</option>";
                    }
                    ?>
                </select><br>
                
                <input class="form-control" type="number" name="stock" value="<?php echo $computer['computerStock']; ?>" required><br>
                
                <div class="button-container">
                    <button class="btn btn-primary btn-custom" type="submit">Guardar</button>
                    <a href="index.php" class="btn btn-salir">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
