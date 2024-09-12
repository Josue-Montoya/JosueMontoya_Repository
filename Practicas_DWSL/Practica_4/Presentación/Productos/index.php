<?php
$form_valid = false;

switch (@$_GET["form"]) {    
    case 'ad':
        $form = 'Presentación/Productos/create.php';
        $form_valid = true;
        break;
    
    case 'up':
        $form = 'Presentación/Productos/update.php';
        $form_valid = true;
        break;
    
    case 'del': 
        $form = 'Presentación/Productos/delete.php';
        $form_valid = true;
        break;
    
    default:
        $form = 'Presentación/Productos/list.php';
        $form_valid = true;
        break;
}

if ($form_valid) {
    require_once $form;
} else {
    header('Location: error404.php');
}