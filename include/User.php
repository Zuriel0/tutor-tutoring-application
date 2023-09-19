<?php
include_once 'DB.php';

class User extends DB{
    private $Name;
    private $Mail;
    private $ID;
    private $url;
    private $tipo;

    // verifica si el usuario y contraseña se encuentra dentro de la tabla de Users
    public function userExists($correo, $pass){
        $md5pass = $pass;
        $query = $this->connect()->prepare('SELECT * FROM Users_tutores WHERE Mail = :user AND password = :pass');
        $query->execute(['user' => $correo, 'pass' => $md5pass]);

        if($query->rowCount()){
            return true;
        }else{
            return false;
        }
    }

    public function setUser($correo){
        $query = $this->connect()->prepare('SELECT * FROM Users_tutores WHERE Mail = :user');
        $query->execute(['user' => $correo]);
        
        foreach ($query as $currentUser) {
            $this->Name = $currentUser['Name'];
            $this->Mail = $currentUser['Mail'];
            $this->ID = $currentUser['ID'];
            $this->url = $currentUser['Url'];
            $this->tipo = $currentUser['Tipo'];
        }
    }

    public function getNombre(){
        return $this->ID;
    }
    public function getUrl(){
        return $this->url;
    }
     public function getTipo(){
        return $this->tipo;
    }

    
}



?>