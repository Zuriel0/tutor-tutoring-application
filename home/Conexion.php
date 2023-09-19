<?php

class conexion{

    private $servername = "localhost";
    private $database = "u149127938_Servicio";
    private $username = "u149127938_Zurich";
    private $password = "Anxzu_97";
    private $conn;
    private $sent;
    private $result;

    public function __construct(){


        try {
            $this->conn= new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            //echo "Connected to $database at $servername successfully"; //no descomentar solo prueba de conexion.
        }catch(PDOException $e){
            echo "Conexion Fallida".$e;
        }
    }

    //Ejecuta sql para la escritura en db
    public function ejecSql($sql){
        $this->conn->exec($sql);
        return $this->conn->lastInsertId();
    }
    //Consulta de db
    public function searchSql($sql){

        $this->sent=$this->conn->prepare($sql);    // Preparmos el comando en la db.
        $this->sent->execute(); //Ejecutamos comandos
        $resultado=$this->sent->fetchAll();  //Buscamos y guardamos los resultados obtenidos. 
        foreach($resultado as $Var );
        return $Var;
    }
}
?>
