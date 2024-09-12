<?php

Class Conf {
    private $server;
    private $user;
    private $password;
    private $database;
    private $connection;
    private $result_query;

    
    public function __construct() {
        $this->server = "localhost"; // IP del localhost, tambien puedes poner localhost
        $this->user = "root"; // tu usuario, root por defecto
        $this->password = "1234"; // tu contrasenia
        $this->database = "dbTienda"; // nombre de la base de datos
    }

    // funcion que nos permite conectarnos al servidor y a su vez a la base de datos
    protected function connect() {
        @$this ->connection = mysqli_connect(
            $this->server,
            $this->user,
            $this->password,
            $this->database)
            or die("error". mysqli_connect_error());
            return $this->connection;
    }
    
    // funcion para cerrar la conexion
    protected function disconnect() {
        return mysqli_close($this->connection);
    }

    //Función para ejecutar querys
    public function exec_query($query) {
        $this->result_query = mysqli_query($this->connect(), $query)
        or die("error". mysqli_error($this->connection));
        $this->disconnect();
        return $this->result_query;
    }


}

