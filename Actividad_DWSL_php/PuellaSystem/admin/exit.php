<?php
session_start();
if ($_SESSION["user"]=="") {
    header("Location: ../index.php");
}
session_destroy();
header("Location: ../index.php");
?>