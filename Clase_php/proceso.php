<?php
$num1=isset($_POST['n1']) ? $_POST['n1']:"";
$num2=isset($_POST['n2']) ? $_POST['n2']:"";
$operador=isset($_POST['operador']) ? $_POST['operador']:"";

switch($operador){
    case '+':
        $respuesta= $num1 + $num2;
        echo "La respuesta de la operacion es: ".$respuesta;
        break;

        default:
        echo $respuesta= "No existe esa condicion";
        break;

    case '-':
        $respuesta= $num1 - $num2;
        echo "La respuesta de la operacion es: ".$respuesta;
        break;

    case '*':
        $respuesta= $num1 * $num2;
        echo "La respuesta de la operacion es: ".$respuesta;
        break;

    case '/':
        $respuesta= $num1 / $num2;
        echo "La respuesta de la operacion es: ".$respuesta;
        break;

}
?>