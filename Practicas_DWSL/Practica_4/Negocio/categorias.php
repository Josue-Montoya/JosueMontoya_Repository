<?php

    require_once "./Datos/conf.php";
    class Categorias extends Conf {

        public function list_categories () {
            $query = "SELECT * FROM categorias";
            return mysqli_fetch_all($this->exec_query($query), MYSQLI_ASSOC);
        }
    }