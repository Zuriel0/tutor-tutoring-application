<?php
//print_r($_POST);
//echo $_POST['solFist'];
require ("User_session.php");           
include("query.php"); 
$userSession = new UserSession();
$dataSession=$userSession->getCurrentUser();
$objConecion = new only_query();
//print_r($dataSession);

if(isset($_POST['solFist'])){
    if($_POST['solFist'] == "1"){
        echo $_POST['solFist'];
        $sql = "UPDATE `solicitudes` SET `status_tutor` = '1' WHERE solicitudes.id_user = ".$dataSession['alumno']." AND solicitudes.id_tutor = ".$dataSession['id'].";";
        //$objConecion->ejecSql($sql);
        $status_sol = query_sol_status( $dataSession['id'], $dataSession['alumno'] );

    }elseif($_POST['solFist'] == 2){
        echo $_POST['solFist'];
        $sql = "UPDATE solicitudes SET status_user = 0, denied = 1 WHERE solicitudes.id_user = ".$dataSession['alumno']." AND solicitudes.id_tutor = ".$dataSession['id'].";";
        //$objConecion->ejecSql($sql);
        $status_sol = query_sol_status( $dataSession['id'], $dataSession['alumno'] );
    }
}
/*
if($_GET['d1'] != ""){
$sql = "UPDATE `dates` SET `state` = '1' WHERE dates.id = ".$status_sol['id']." ;";
$objConecion->executeSql($sql);
$date = query_date_colcult($status_sol['id']);
}elseif($_GET['d2'] != ""){
$sql = "DELETE FROM dates WHERE id = ".$status_sol['id']." ;";
$objConecion->executeSql($sql);
$date = query_date_colcult($status_sol['id']);
header ('location: details.php?id='.$id.'&token='.$token);
}
if($_GET['f1'] != ""){
$sql = "UPDATE `dates` SET `status_tutor` = '1' WHERE dates.id = ".$status_sol['id']." ;";
$objConecion->executeSql($sql);
$date = query_date_colcult($status_sol['id']);
header ('location: details.php?id='.$id.'&token='.$token);
}elseif($_GET['f2'] != ""){
$sql = "UPDATE `dates` SET `status_tutor` = '0' WHERE dates.id = ".$status_sol['id']." ;";
$objConecion->executeSql($sql);
$date = query_date_colcult($status_sol['id']);
header ('location: details.php?id='.$id.'&token='.$token);
}
*/

?>