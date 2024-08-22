<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="proceso.php" method="POST">
        <br>
        <label for="n1">Digite el primer numero</label>    
        <br>
        <input type="number" name="n1" id="">
        <br>
        <br>
        <select name="operador" id="">
            <option value="0">Seleccione</option>
            <option value="+">Suma</option>
            <option value="-">Resta</option>
            <option value="*">Multiplicación</option>
            <option value="/">División</option>
        </select>
        <br>
        <br>
        <label for="n2">Digite el segundo número</label>
        <br>
        <input type="number" name="n2" id="">
        <br>
        <br>

        <input type="Submit" value="Calcular">
    </form>    
</body>
</html>

