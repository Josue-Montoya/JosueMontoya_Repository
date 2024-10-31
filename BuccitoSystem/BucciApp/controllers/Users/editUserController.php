<?php

include '../../conf/conf.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_usuario']; // ID del usuario a editar
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $id_rol = $_POST['id_rol'];

    // Si la contraseña no se ha cambiado, no la hasheamos
    if (!empty($clave)) {
        $clave = password_hash($clave, PASSWORD_DEFAULT); // Hashear la nueva contraseña
        $sql = "UPDATE tbl_usuarios SET nombre = :nombre, usuario = :usuario, clave = :clave, id_rol = :id_rol WHERE id_usuario = :id_usuario";
    } else {
        // Si no se cambia la contraseña, omitimos el campo clave
        $sql = "UPDATE tbl_usuarios SET nombre = :nombre, usuario = :usuario, id_rol = :id_rol WHERE id_usuario = :id_usuario";
    }

    try {
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':id_rol', $id_rol);
        $stmt->bindParam(':id_usuario', $id_usuario);

        if (!empty($clave)) {
            $stmt->bindParam(':clave', $clave);
        }

        $stmt->execute();

        // Redirecciona a la página de usuarios después de editar
        header("Location: ../../views/users/indexUser.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al editar el usuario: " . $e->getMessage();
    }
}
?>
