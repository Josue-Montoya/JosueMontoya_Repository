<?php
$usuario= isset($_POST['usuario']) ? $_POST['usuario']:"";
$pwd= isset($_POST['pwd']) ? $_POST['pwd']:"";

$listaUsuarios = [
    [
    'usuario' => 'administrador',
    'rol' => 1,
    'pwd' => '123'
    ],
    [
    'usuario' => 'editor',
    'rol' => 2,
    'pwd' => '123'
    ],
    [
    'usuario' => 'usuario',
    'rol' => 3,
    'pwd' => '123'
    ]
]     
?>