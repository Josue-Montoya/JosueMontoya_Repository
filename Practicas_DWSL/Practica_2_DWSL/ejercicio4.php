<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4</title>
</head>
<body>
<div class="container">
        <div class="card m-auto mt-5">
            <form action="ejercicio4.php" method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Número del día a mostrar:</label>
                        <input type="text" class="form-control" name="txtDia">
                    </div>
                    <div class="col-md-3 mt-4">
                        <button class="btn btn-info">Mostrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php
    if(isset($_POST["txtDia"])){
        
        $dia = "";

        switch($_POST["txtDia"]){
            case 1:
                $dia = "Lunes";
                break;

            case 2:
                $dia = "Martes";
                break;
            
            case 3:
                $dia = "Miércoles";
                break;
            
            case 4:
                $dia = "Jueves";
                break;

            case 5:
                $dia = "Viernes";
                break;
            
            case 6:
                $dia = "Sábado";
                break;
            
            case 7:
                $dia = "Domingo";
                break;
            
            default:
                $dia = "¡Día no existente!";
                break;
        }
    }

    echo "<br>";
    echo "El día es: ".$dia;
?>