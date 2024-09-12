<?php
    include_once("../conf/conf.php");

    //Variables
    $options = isset( $_POST['theFlag'] ) ? $_POST['theFlag'] :"";
    $pcID = isset( $_POST["computerID"] ) ? $_POST["computerID"] :"";
    $name = isset( $_POST['name'] ) ? $_POST['name'] :"";
    $brand = isset( $_POST['brand'] ) ? $_POST['brand'] :"";
    $stock = isset( $_POST['stock'] ) ? $_POST['stock'] :"";
    
    $delOption = isset( $_GET['delFlag'] ) ? $_GET['delFlag'] :"";
    $delID = isset( $_GET["computerID"] ) ? $_GET["computerID"] :"";

    if( $options == 1){
        $query = "INSERT INTO tbl_Computers (computerID, computerName, computerStock, brandID)
        VALUES (NULL, '$name', $stock, $brand);";
    
     $execute = mysqli_query($con, $query);
     if($execute){
        header("Location: index.php");
     }else{ 
        echo "Error en la consulta";
    }
    }elseif( $options == 2){
        $query = "UPDATE tbl_Computers SET computerName = '$name', computerStock = $stock, brandID = $brand 
        WHERE computerID = $pcID;";

        $execute = mysqli_query($con, $query);

        if($execute){
           header("Location: index.php");
        }else{ 
            echo "Error en la consulta";
        }
    }elseif( $delOption == 3){
        $query = "DELETE FROM tbl_Computers WHERE computerID = $delID;";
        
        $execute = mysqli_query($con, $query);

        if($execute){
           header("Location: index.php");
        }else{ 
            echo "Error en la consulta";
        }
    }
    
    $con -> close();
?>