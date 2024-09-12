<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Agregar Cliente</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Agregar registro</h2>
        <form action="process.php" method="POST" class="border p-4 shadow-sm rounded">
            <input type="text" value="1" name="flag" hidden>
            
            <div class="mb-3">
                <label for="theName" class="form-label">Nombre</label>
                <input type="text" name="theName" class="form-control" id="theName" required>
            </div>
            
            <div class="mb-3">
                <label for="phone" class="form-label">Teléfono</label>
                <input type="text" name="phone" class="form-control" id="phone" required>
            </div>
            
            <div class="mb-3">
                <label for="dui" class="form-label">DUI</label>
                <input type="text" name="dui" class="form-control" id="dui" required>
            </div>
            
            <div class="mb-3">
                <label for="mail" class="form-label">Correo</label>
                <input type="email" name="mail" class="form-control" id="mail" required>
            </div>
            
            <div class="mb-3">
                <label for="address" class="form-label">Dirección</label>
                <input type="text" name="address" class="form-control" id="address">
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+8Y1WmOUqcVvfYs7ZZrhT2lBgfbK5" crossorigin="anonymous"></script>
</body>
</html>
