<?php
    include_once("../conf/conf.php");

    //Variables
    $options = isset( $_POST['theFlag'] ) ? $_POST['theFlag'] :"";
    $brandID = isset( $_POST["BrandID"] ) ? $_POST["BrandID"] :"";
    $name = isset( $_POST['name'] ) ? $_POST['name'] :"";
    
    $delOption = isset( $_GET['delFlag'] ) ? $_GET['delFlag'] :"";
    $delID = isset( $_GET["BrandID"] ) ? $_GET["BrandID"] :"";

    if( $options == 1){
        $query = "INSERT INTO tbl_Brand (BrandID, brandName) VALUES (NULL, '$name');";
    
     $execute = mysqli_query($con, $query);
     if($execute){
        header("Location: brands.php");
     }else{ 
        echo "Error en la consulta";
    }
    }elseif( $options == 2){
        $query = "UPDATE tbl_Brand SET brandName = '$name' WHERE BrandID = $brandID;";

        $execute = mysqli_query($con, $query);

        if($execute){
           header("Location: brands.php");
        }else{ 
            echo "Error en la consulta";
        }
    }elseif( $delOption == 3){
        $query = "DELETE FROM tbl_Brand WHERE BrandID = $delID;";
        
        $execute = mysqli_query($con, $query);

        if($execute){
           header("Location: brands.php");
        }else{ 
            echo "Error en la consulta";
        }
    }
    
    $con -> close();
?>