<?php
function mont ( $mont, $mont_act, $desfase ){
    if($desfase == 0){
        return $mont[$mont_act];
    }else {
        $mont_act = $mont_act -$desfase;
        if($mont_act<0){
            $mont_act = $mont_act + 13;
            return $mont[$mont_act];
        }else{
            return $mont[$mont_act];
        }
    }
}
$sql = "SELECT * FROM detalles_tutor WHERE id_tutor = ".$dataSession['id']."";
$cal = $objConecion->searchSql($sql);
$calificacion = $cal['calificacion'] / $cal['tutorias_completadas'];
$recomendacion = $cal['recomendación'] / $cal['tutorias_completadas'];
$dificultad = $cal['dificultad'] / $cal['tutorias_completadas'];
$sql = "SELECT COUNT(id_tutor) FROM solicitudes WHERE id_tutor = ".$dataSession['id']." AND status_tutor = 1 AND status = 0;";
$val1 = $objConecion->searchSql($sql);
$mont_act = date('m');
$mont = array(
    1 => 'enero',
    2 => 'febrero',
    3 => 'marzo',
    4 => 'abril',
    5 => 'mayo',
    6 => 'junio',
    7 => 'julio',
    8 => 'agosto',
    9 => 'septiembre',
    10 => 'octubre',
    11 => 'noviembre',
    12 => 'diciembre'
);
$sql = "SELECT initDate FROM dates WHERE id_user = ".$dataSession['id']." AND completado = 0 ORDER BY dates.initDate DESC;";
$dateTime = $objConecion->searchSql($sql);
$sql = "SELECT * FROM dates WHERE id_user = ".$dataSession['id']." AND tiempo != 0;";
$dates = $objConecion->searchSql_Assoc($sql);
$sql = "SELECT * FROM dates WHERE id_user = ".$dataSession['id']." AND tiempo != 0;";
$dates_chek = $objConecion->searchSql($sql);
?>

