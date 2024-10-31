
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./BucciApp/css/login.css">
    <title>Login BucciApp</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center pt-5 mt-5 m-1">
            <div class="col-md-6 col-sm-8 col-xl-4 col-lg-5 formulario">
                <form action="" method="POST">
                    <div class="form-group text-center pt-3">
                        <h1 class="text-light">Iniciar Sesion</h1>
                    </div>
                    <div class="form-group mx-sm-4 pt-3">
                        <input type="text" class="form-control" required name="user" placeholder="Usuario">
                    </div>
                    <div class="form-group mx-sm-4 pb-4">
                        <input type="text" class="form-control" required name="pwd" placeholder="Contraseña">
                    </div>
                    <div class="form-group mx-sm-4 pb-3">
                        <button type="submit" class="btn btn-block ingresar" value="Ingresar">Ingresar</button>
                    </div>
                    <div class="form-group mx-sm-4 text-center pb-5">
                        <span><a class="olvide" href="#">Olvidaste tu contraseña?</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>


<?php
include_once "./BucciApp/conf/conf.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = isset($_POST['user']) ? $_POST['user'] : "";
    $pwd = isset($_POST['pwd']) ? $_POST['pwd'] : "";

    $query = "
        SELECT id_usuario, nombre, usuario, clave, r.nombre_rol 
        FROM tbl_usuarios u 
        INNER JOIN tbl_roles r ON u.id_rol = r.id_rol 
        WHERE u.usuario = :user";
        
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':user', $user);
    $stmt->execute();
    $userFound = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userFound && password_verify($pwd, $userFound["clave"])) {
        session_start();
        $_SESSION["user"] = $userFound['nombre_rol'];
        $_SESSION["userID"] = $userFound['id_usuario'];
        $_SESSION["username"] = $userFound['nombre'];

        if ($userFound['nombre_rol'] == 'administrador') {
            header('Location: ./BucciApp/views/admin.php');
            exit(); // Asegúrate de que el script termine después de redirigir
        } elseif ($userFound['nombre_rol'] == 'empleado') {
            header('Location: ./BucciApp/views/Sales/indexSales.php');
            exit(); // Asegúrate de que el script termine después de redirigir
        } else {
            echo "<script>alert('Tipo de usuario no reconocido')</script>";
        }
    } else {
        echo "<script>alert('Error en el inicio de sesión')</script>";
    }
}
?>

