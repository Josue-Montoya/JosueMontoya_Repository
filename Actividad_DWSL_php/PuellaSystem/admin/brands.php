<?php
session_start();
if ($_SESSION['user'] == "") {
    header("Location: ./index.php");
}


if (!isset($_SESSION['welcome_shown'])) {
    $_SESSION['welcome_shown'] = true;
    echo "<script>alert('Bienvenido " . $_SESSION['user'] . "');</script>";
}

include_once("../conf/conf.php");

$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

$query = "SELECT BrandID, brandName FROM tbl_Brand 
          WHERE BrandID LIKE '%$search%' 
          OR brandName LIKE '%$search%'";

$execute = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/brands.css"> 
    <title>Marcas</title>
</head>

<body>
    <div class="container mt-5">
        <nav class="nav nav-pills flex-column flex-sm-row mb-4">
            <a class="flex-sm-fill text-sm-center nav-link" href="#" id="welcomeMessage"></a>
        </nav>

      
        <div class="d-flex justify-content-between mb-3">
            <a href="addBrand.php" class="btn btn-success btn-custom">Agregar marca</a>
            <div class="d-flex">
                <a href="index.php" class="btn btn-marca btn-custom">Computadoras</a>
                <a href="exit.php" class="btn btn-salir btn-custom">Salir</a>
            </div>
        </div>

      
        <form method="POST" class="d-flex mb-4">
            <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar" name="search" value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-outline-info" type="submit">Buscar</button>
        </form>

        
        <h2 class="text-center mb-4">Listado de Marcas</h2>

        
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($execute)) {
                        echo "<tr>";
                        echo "<td>" . $row[0] . "</td>";
                        echo "<td>" . $row[1] . "</td>";
                        echo "<td>
                                <a href='editBrand.php?BrandID=" . $row[0] . "' class='btn btn-primary btn-sm'>Modificar</a> 
                                <a href='brandControls.php?BrandID=" . $row[0] . "&delFlag=3' class='btn btn-danger btn-sm'>Eliminar</a>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
