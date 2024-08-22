<?php

    $num1=$_POST['n1'];
    $num2=$_POST['n2'];
    $operador=$_POST['operador'];
    
    switch($operador){
        case '+':
            $respuesta = $num1 + $num2;
            break;
        case '-':
            $respuesta = $num1 - $num2;
            break;
        case '*':
            $respuesta = $num1 * $num2;
            break;
        case '/':
            $respuesta = $num1 / $num2;
            break;
        default:
            $respuesta = "No existe esa condición.";
        break;
    }

    echo "La respuesta de la operación es: ".$respuesta;
?>