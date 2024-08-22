<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<?php
//Capturando datos
$usuario = isset($_POST['usuario']) ? $_POST['usuario']:""; 
$pwd = isset($_POST['pwd']) ? $_POST['pwd']:"";

$listaUsuarios= [ //Array con los datos de usuario
    [
        'usuario' => 'administrador',
        'rol' => '1',
        'pwd'=> '123',
    ],
    [
        'usuario' => 'editor',
        'rol' => '2',
        'pwd'=> '123',
    ],
    [
        'usuario' => 'usuario',
        'rol' => '3',
        'pwd'=> '123',
    ]
    ];

//Recorriendo el array:
foreach ($listaUsuarios as $lista){
    if($usuario == $lista['usuario'] && $pwd == $lista['pwd'] && $lista['rol']==1){
        include_once('nav1.php');
    }
    else if($usuario == $lista['usuario'] && $pwd == $lista['pwd'] && $lista['rol']==2){   
        include_once('nav2.php');
    }
    else if($usuario == $lista['usuario'] && $pwd == $lista['pwd'] && $lista['rol']==3){
        include_once('nav3.php');
    }
}

?>