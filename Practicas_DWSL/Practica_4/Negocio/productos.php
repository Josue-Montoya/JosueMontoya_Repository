<?php
    require_once './Datos/conf.php';
    class Productos extends Conf{
        public $name;
        public $description;
        public $categorie;

        public function list_products() {
            $query = "SELECT * FROM productos";
            return mysqli_fetch_all($this ->exec_query($query), MYSQLI_ASSOC);
        }
        public function add(){
            $query = "INSERT INTO productos (id, name, description, id_categorie)
                    VALUES(NULL,'".$this->name."', '".$this->description."', '".$this->categorie."')";
            
            return $this ->exec_query($query);
        }

        public function update($id){
            $query = "UPDATE productos SET name = '".$this->name."', description = '".$this->description."',
                    id_categorie = '".$this->categorie."' WHERE id = '".$id."' ";

            return $this->exec_query($query);
        }

        public function delete($id){
            $query = "DELETE FROM productos WHERE id = '".$id."' ";
            return $this->exec_query($query);
        }

        public function get_producto($id){
            $query = "SELECT * FROM productos WHERE id = '".$id."'";
            return mysqli_fetch_all($this->exec_query($query), MYSQLI_ASSOC);
        }
            
    }
?>