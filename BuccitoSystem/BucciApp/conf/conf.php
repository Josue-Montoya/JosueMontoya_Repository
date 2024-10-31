<?php

    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = '1234';
    $db_name = 'bucci';

    try {
        // Crear una conexión PDO a la base de datos
        $connection = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_username, $db_password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error al conectar a la base de datos: " . $e->getMessage();
    }

?>
