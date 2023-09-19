<?php

class UserSession{

    public function __construct(){
        session_start();
    }

    public function setCurrentUser($user, $id, $url, $tipo){
        $_SESSION['user'] = $user;
        $_SESSION['id'] = $id;
         $_SESSION['url'] = $url;
         $_SESSION['tipo'] = $tipo;
    }
    public function setCurrentTutor($alumno){
        $_SESSION['alumno'] = $alumno;
    }

    public function getCurrentUser(){
        return $_SESSION;
    }

    public function closeSession(){
        session_unset();
        session_destroy();
    }
}

?>