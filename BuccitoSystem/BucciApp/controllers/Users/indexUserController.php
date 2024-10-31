<!-- indexUserController.php -->
<?php
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

include '../../conf/conf.php';

$sql = "SELECT u.id_usuario, u.nombre, u.usuario, r.nombre_rol 
        FROM tbl_usuarios AS u
        INNER JOIN tbl_roles AS r ON u.id_rol = r.id_rol";

if (!empty($search)) {
    $sql .= " WHERE u.nombre LIKE :search OR u.usuario LIKE :search OR r.nombre_rol LIKE :search";
}

try {
    $stmt = $connection->prepare($sql);
    
    if (!empty($search)) {
        $searchParam = "%$search%";
        $stmt->bindParam(':search', $searchParam);
    }
    
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    echo "Error al obtener la lista de usuarios: " . $e->getMessage();
}
?>