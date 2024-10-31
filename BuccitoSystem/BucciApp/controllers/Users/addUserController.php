<?php

include '../../conf/conf.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT); // Hash de la clave
    $id_rol = $_POST['id_rol'];

    $sql = "INSERT INTO tbl_usuarios (nombre, usuario, clave, id_rol)
            VALUES (:nombre, :usuario, :clave, :id_rol)";

    try {
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':clave', $clave);
        $stmt->bindParam(':id_rol', $id_rol);
        $stmt->execute();

        // Redirecciona a la página de usuarios después de agregar el nuevo usuario
        header("Location: ../../views/users/indexUser.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al crear el usuario: " . $e->getMessage();
    }
}
?>
