<?php

$server = "localhost";
$user = "root";
$pass = "1234";
$db = "PuellaDB";

$con = mysqli_connect($server, $user, $pass, $db);
if ($con) {
    //echo"Conexión realizada";
}
else {
    echo "Error de conexión";
}
?>