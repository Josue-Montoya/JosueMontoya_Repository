<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Editar Cliente</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Editar registro</h2>
        <?php
            include_once ("./conf/conf.php");
            $objeto = new Connection();
            $puellaConnect = $objeto->Connect();

            $ClientID = isset($_GET['id']) ? $_GET['id'] : "";
            
            $query = "SELECT * FROM Client WHERE ClientID = :daID";
            $result = $puellaConnect->prepare($query);
            $result->bindParam(':daID', $ClientID, PDO::PARAM_INT);
            $result->execute();

            if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <form action="process.php" method="POST" class="border p-4 shadow-sm rounded">
            <input type="hidden" name="flag" value="2">
            <input type="hidden" name="ClientID" value="<?php echo $ClientID; ?>">

            <div class="mb-3">
                <label for="theName" class="form-label">Nombre:</label>
                <input class="form-control" type="text" name="theName" id="theName" value="<?php echo htmlspecialchars($row['Name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Teléfono:</label>
                <input class="form-control" type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($row['Tel']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="dui" class="form-label">DUI:</label>
                <input class="form-control" type="text" name="dui" id="dui" value="<?php echo htmlspecialchars($row['DUI']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="mail" class="form-label">Correo electrónico:</label>
                <input class="form-control" type="email" name="mail" id="mail" value="<?php echo htmlspecialchars($row['Mail']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Dirección:</label>
                <input class="form-control" type="text" name="address" id="address" value="<?php echo htmlspecialchars($row['Address']); ?>" required>
            </div>

            <div class="d-grid">
                <button class="btn btn-primary" type="submit">Guardar</button>
            </div>
        </form>
        <?php
            } else {
                echo "<div class='alert alert-danger text-center'>No se encontraron datos para el cliente con ID: $ClientID</div>";
            }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+8Y1WmOUqcVvfYs7ZZrhT2lBgfbK5" crossorigin="anonymous"></script>
</body>
</html>

