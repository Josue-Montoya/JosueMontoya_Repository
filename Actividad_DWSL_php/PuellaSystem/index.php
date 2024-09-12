<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css">

    <title>Puella Inventory</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-6 col-lg-4 login-container">
            <form id="loginForm" action="index.php" method="POST">
                <div class="form-group text-center mb-4">
                    <h1 class="text-light">Iniciar Sesión</h1>
                </div>
                <div class="form-group mb-3">
                    <input type="text" class="form-control" id="user" name="user" placeholder="Usuario">
                </div>
                <div class="form-group mb-4">
                    <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Contraseña">
                </div>
                <div class="form-group text-center mb-3">
                    <button type="submit" class="btn btn-custom btn-block">Iniciar Sesión</button>
                </div>
                
            </form>
        </div>
    </div>

    <script>
      
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            const user = document.getElementById('user').value.trim();
            const pwd = document.getElementById('pwd').value.trim();

            if (user === "" || pwd === "") {
                event.preventDefault(); 
                alert("Por favor, complete ambos campos.");
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Dn5XxaOf6D8A4GpmH19Q5Q/cLJlHQ5w44Q8DpBa2uFu7zg" crossorigin="anonymous"></script>
</body>

</html>


<?php
include_once "./conf/conf.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = isset($_POST['user']) ? $_POST['user'] : "";
    $pwd = isset($_POST['pwd']) ? $_POST['pwd'] : "";

    if (!empty($user) && !empty($pwd)) {
        $query = "SELECT userOwner, userName, userPass FROM tbl_Users WHERE userName='" . mysqli_real_escape_string($con, $user) . "' && userPass='" . md5($pwd) . "'";
        $execute = mysqli_query($con, $query);

        if ($execute && $execute->num_rows == 1) {
            while ($theUser = mysqli_fetch_assoc($execute)) {
                $_SESSION["user"] = $theUser['userOwner'];
            }
            header('Location: ./admin/index.php');
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    } else {
        $error = "Por favor, complete todos los campos.";
    }
}
?>


<?php if (isset($error)): ?>
    <div class="alert alert-danger text-center mt-3">
        <?php echo $error; ?>
    </div>
<?php endif; ?>