<?php

class Connection{
    private $server = "localhost";
    private $db = "dbClientes";
    private $user = "root";
    private $pass = "1234";

    public $conn;
    public function Connect(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=". $this->server."; dbname=".$this->db, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Conexión éxitosa.";
        }catch(PDOException $exec){
            echo "Error en la conexión: ". $exec->getMessage();
        }
        return ($this->conn);
    }
}
?>