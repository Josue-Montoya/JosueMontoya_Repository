<?php
    include_once ("./conf/conf.php");
    $objeto = new Connection();

    $puellaConnect = $objeto->Connect();

    //Captura de datos
    $theFlag = isset($_POST["flag"]) ? $_POST["flag"] :"";
    $name = isset($_POST["theName"]) ? $_POST["theName"] :"";
    $Tel = isset($_POST["phone"]) ? $_POST["phone"] :"";
    $DUI = isset($_POST["dui"]) ? $_POST["dui"] :"";
    $Mail = isset($_POST["mail"]) ? $_POST["mail"] :"";
    $Address = isset($_POST["address"]) ? $_POST["address"] :"";

    //Captura del flag de eliminar
    $delFlag = 0;
    $delFlag = isset($_GET["delFlag"]) ? $_GET["delFlag"] :"";

    if($theFlag == 1){//Si se crea
        $query = "INSERT INTO Client (ClientID, Name, Tel, DUI, Mail, Address)
                 VALUES (NULL, :daName, :daPhone, :daDUI, :daMail, :daAddress)";
        $result= $puellaConnect->prepare($query);
        $result->bindParam(':daName', $name); $result->bindParam(':daPhone', $Tel);
        $result->bindParam(':daDUI', $DUI); $result->bindParam(':daMail', $Mail);
        $result->bindParam(':daAddress', $Address);

        if($result->execute()){
            header('Location: index.php');
        }else{
            echo'Error';
        }
    }else if($theFlag == 2){//Si se edita
        
        $ID = isset($_POST["ClientID"]) ? $_POST["ClientID"] :"";
        $query = "UPDATE Client SET Name = :daName, Tel = :daPhone, DUI = :daDUI, Mail = :daMail, Address = :daAddress WHERE ClientID = :daID";
        $result= $puellaConnect->prepare($query);
        $result->bindParam(':daName', $name); $result->bindParam(':daPhone', $Tel);
        $result->bindParam(':daDUI', $DUI); $result->bindParam(':daMail', $Mail);
        $result->bindParam(':daAddress', $Address); $result->bindParam(':daID', $ID);

        if($result->execute()){
        header('Location: index.php');
        }else{
        echo'Error';
        }
    }else if($delFlag == 3){//Si se borra
        $delID = isset($_GET["ClientId"]) ? $_GET["ClientId"] :"";
        $query = "DELETE FROM Client WHERE ClientID = :daID";
        $result= $puellaConnect->prepare($query);
        $result->bindParam(':daID', $delID);
        
        if($result->execute()){
            header('Location: index.php');
        }else{
            echo'Error';
        }
    }else{
        echo 'How did you get here?';
    }
?>