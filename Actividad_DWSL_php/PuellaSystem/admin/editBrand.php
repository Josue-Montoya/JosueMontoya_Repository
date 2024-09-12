<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/editBrand.css"> 
    <title>Editar Marcas</title>
</head>

<body>
    <?php
        include_once "../conf/conf.php";
        $BrandID = isset($_GET['BrandID']) ? $_GET['BrandID'] : "";
        $query = "SELECT * FROM tbl_Brand WHERE BrandID=".$BrandID;
        $execute = mysqli_query($con, $query);
    ?>

    <div class="container mt-5">
       
        <h2 class="text-center mb-4">Editando Marca</h2>
        
        <form action="brandControls.php" method="POST">
            <div class="form-group">
                <input type="text" name="theFlag" value="2" hidden>
                <input type="text" name="BrandID" value="<?php echo $BrandID; ?>" hidden>
                <?php while($row = mysqli_fetch_array($execute)) { ?>
                <input class="form-control mb-3" type="text" name="name" value="<?php echo $row[1]; ?>" required><br>
                
                
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary btn-custom" type="submit">Guardar</button>
                    <a href="brands.php" class="btn btn-salir">Salir</a>
                </div>
                <?php } ?>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
