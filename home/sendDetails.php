<?php

//echo "console.log('Que pedo');";

//print_r($_POST);
//echo $_POST['solFist'];
require ("./../include/User_session.php");           
include("./../include/query.php"); 
$userSession = new UserSession();
$dataSession=$userSession->getCurrentUser();
$objConecion = new only_query();
$sql = "SELECT * FROM dates WHERE id = ".$dataSession['id_chat']." AND completado = 0  ";
//$sql = "SELECT solicitudes.id, solicitudes.status_tutor, solicitudes.status_user, solicitudes.denied FROM solicitudes WHERE solicitudes.id_tutor = ".$dataSession['id']." AND solicitudes.id_user = ".$dataSession['alumno'].";";
$status_sol = $objConecion->searchSql($sql);
//print_r($dataSession);
//print_r($status_sol);

if(isset($_POST['solFist'])){
    if($_POST['solFist'] == 1){
        
        $sql = "UPDATE `solicitudes` SET `status_tutor` = '1' WHERE solicitudes.id_user = ".$dataSession['alumno']." AND solicitudes.id_tutor = ".$dataSession['id'].";";
        $objConecion->ejecSql($sql);
        $status_sol = query_sol_status( $dataSession['id'], $dataSession['alumno'] );        
    }elseif($_POST['solFist'] == 2){
        
        $sql = "UPDATE solicitudes SET status_user = 0, denied = 1 WHERE solicitudes.id_user = ".$dataSession['alumno']." AND solicitudes.id_tutor = ".$dataSession['id'].";";
        $objConecion->ejecSql($sql);
        $status_sol = query_sol_status( $dataSession['id'], $dataSession['alumno'] );
    }
}


if(isset($_POST['solDate'])){
    
    if($_POST['solDate'] == 1){
        
        $sql = "UPDATE `dates` SET `state` = '1' WHERE dates.id = ".$status_sol['id']." AND Id_date = ".$status_sol['Id_date']." ;";
        $objConecion->executeSql($sql);
    }elseif($_POST['solDate'] == 2){
        $sql = "DELETE FROM dates WHERE dates.Id_date = ".$status_sol['Id_date']."";
        //$sql = "UPDATE `dates` SET `completado` = '1', `status_user` = '3' WHERE dates.id = ".$status_sol['id']." AND Id_date = ".$status_sol['Id_date'].";";
        $objConecion->executeSql($sql);
    }
}


if(isset($_POST['solConf'])){
    if($_POST['solConf']== 1){
        $sql = "UPDATE `dates` SET `status_tutor` = '1' WHERE dates.id = ".$status_sol['id']." AND Id_date = ".$status_sol['Id_date']." ;";
        $objConecion->executeSql($sql);
    }elseif($_POST['solConf'] == 2){
        $sql = "UPDATE `dates` SET `status_tutor` = '0' WHERE dates.id = ".$status_sol['id']." AND Id_date = ".$status_sol['Id_date']." ;";
        $objConecion->executeSql($sql);
    }
}


?>