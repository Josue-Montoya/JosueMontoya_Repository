<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="app3.php" method="POST">
        <table>
            <tr>
                <th>Matemáticas</th>
                <th>Lenguaje</th>
                <th>Ciencias</th>
                <th>Sociales</th>
                <th>Moral</th>
            </tr>
            <tr>
                <td><input type="number" name="m" id="" value="<?php echo isset($_POST['m']) && !isset($_POST['reset']) ? $_POST['m'] : ''; ?>"></td>
                <td><input type="number" name="l" id="" value="<?php echo isset($_POST['l']) && !isset($_POST['reset']) ? $_POST['l'] : ''; ?>"></td>
                <td><input type="number" name="c" id="" value="<?php echo isset($_POST['c']) && !isset($_POST['reset']) ? $_POST['c'] : ''; ?>"></td>
                <td><input type="number" name="s" id="" value="<?php echo isset($_POST['s']) && !isset($_POST['reset']) ? $_POST['s'] : ''; ?>"></td>
                <td><input type="number" name="mr" id="" value="<?php echo isset($_POST['mr']) && !isset($_POST['reset']) ? $_POST['mr'] : ''; ?>"></td>
            </tr>
        </table>
        <br>
        <?php if (!isset($_POST['submit']) || isset($_POST['reset'])): ?>
            <input type="submit" name="submit" value="Promediar">
        <?php endif; ?>
        
        <?php if (isset($_POST['submit']) && !isset($_POST['reset'])): ?>
            <input type="submit" name="reset" value="Promediar nuevo estudiante">
        <?php endif; ?>
    </form>
    <br>
</body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] === "POST"){
    $matematica= isset($_POST["m"]) ? $_POST["m"] :"";
    $lenguaje= isset($_POST["l"]) ? $_POST["l"] :"";
    $ciencia= isset($_POST["c"]) ? $_POST["c"] :"";
    $sociales= isset($_POST["s"]) ? $_POST["s"] :"";
    $moral= isset($_POST["mr"]) ? $_POST["mr"] :"";
    
    $promedio = ($matematica + $lenguaje + $ciencia + $sociales + $moral) / 5;

    if($promedio >= 7 && $promedio <= 10){
        echo "El estudiante APROBÓ con un promedio de: ".$promedio;
    }else if($promedio >= 0 && $promedio < 7){
        echo "El estudiante REPROBÓ con un promedio de: ".$promedio;
    }else{
        echo "El promedio resultante (".$promedio, ") es inválido (no está entre el 0 al 10), verifique los datos ingresados.";
    }
}
?>