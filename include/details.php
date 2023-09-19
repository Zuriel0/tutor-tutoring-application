<?php
require ("./../include/User_session.php");
require ("./../include/query.php");
$userSession = new UserSession();
$dataSession=$userSession->getCurrentUser();

function dateTime ($arg, $seps){
  $sep = $seps;
  $cad = $arg;
  $Separador = explode($sep, $cad);
  return $Separador;
}
function timeComparer ( $initTime, $finishTime ){
  $dateConf = dateTime($initTime,":");
  $dateConf2 = dateTime($finishTime,":");
  if($dateConf[0]==$dateConf2[0]){
    $min = $dateConf2[1] - $dateConf[1];
    return "00:".sprintf("%02d",$min);
  }elseif($dateConf2[0]==$dateConf[0]+1){
    $min = (60 - $dateConf[1]) + $dateConf2[1]; 
    if($min>=60){
      $min = $min - 60;
      return "01:".sprintf("%02d",$min);
    }
    return "00:".sprintf("%02d",$min);
  }elseif($dateConf2[0]>$dateConf[0]+1){
    $min = (60 - $dateConf[1]) + $dateConf2[1]; 
    $horas = $dateConf2[0] - $dateConf[0];
    if($min>=60){
      $min = $min - 60;
      $horas = $horas; 
      return $horas.":".sprintf("%02d",$min);
    }
    return $horas.":".sprintf("%02d",$min);
  }
}
function adderTime($time, $time2){
  $time = dateTime($time,":");
  $time2 = dateTime($time2,":");
  $min = $time[1] + $time2[1];
  $horas = $time[0] + $time2[0];
  if($min>=60){
    $min = $min - 60;
    $horas = $horas + 1;
    return sprintf("%02d",$horas).":".sprintf("%02d",$min);
  }
  return sprintf("%02d",$horas).":".sprintf("%02d",$min);
}


$objConecion= new only_query();
$sql = "SELECT solicitudes.id, solicitudes.status_tutor, solicitudes.status_user, solicitudes.denied FROM solicitudes WHERE solicitudes.id_tutor = ".$dataSession['id']." AND solicitudes.id_user = ".$dataSession['alumno'].";";
$status_sol = $objConecion->searchSql($sql);
$date = query_date_colcult($status_sol['id']);
if( isset($date) && $date['status_tutor'] !=3 ){
  $dateConf = dateTime($date['initDate'], " ");
  $initDate = $dateConf[0]; $initTime = $dateConf[1]; 
  $dateConf = dateTime($date['finishDate'], " ");
  $finishDate = $dateConf[0]; $finishTime = $dateConf[1];
  if(($date['status_tutor'] == 0 && $date['status_user'] == 0) || ($date['status_tutor'] == 0 && $date['status_user'] == 1) || ($date['status_tutor'] == 1 && $date['status_user'] == 0)){
    $sql = "DELETE FROM dates WHERE id = ".$status_sol['id']." ;";
    $objConecion->executeSql($sql);
    $date = query_date_colcult($status_sol['id']);
  }elseif ($date['status_tutor'] == 1 && $date['status_user'] == 1 && $date['completado'] == 0 ) {
    $time = timeComparer($initTime,$finishTime);
    $time_tmp= $time;
    $sql = "SELECT tiempo FROM Users_tutores WHERE ID = ".$date['id_tutor']." ;";
    $inf_tutor = $objConecion->searchSql($sql);
    $tiempoo = $inf_tutor['tiempo'];
    $time = adderTime( $time, $inf_tutor['tiempo']);
    $sql = "UPDATE Users_tutores SET tiempo =  '$time'  WHERE Users_tutores.ID = ".$date['id_tutor']." ;";
    $objConecion->ejecSql($sql);
    $sql = "UPDATE dates SET completado = '1', state = '1', tiempo =  '$time_tmp' WHERE Id_date =".$date['Id_date']."  AND id = ".$status_sol['id']." ;";
    $objConecion->executeSql($sql);
    $date = query_date_colcult($status_sol['id']);
  }

}


?>


<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>  -->

<div class = "row align-items-end">
                    <div class="col-auto" id=""> 
                      <?php if($status_sol['status_tutor']==0 && $status_sol['status_user']==1){ ?>
                        <button class="btn btn-success" onclick="jQuery('solFist', 1 );">Aceptar Solicitud</button>
                        <button class="btn btn-danger" onclick="jQuery('solFist', 2);">Rechazar Solicitud</button>
                        <div id="ID_Mostrar_info"></div>
                      <?php } if($status_sol['denied']==1 && $status_sol['status_tutor']==0){ ?>
                        <a type="submit" class="btn btn-warning" href="Home.php" name="back"  id="">Volver a pagina anterior</a>
                      <?php  } if ($status_sol['status_user']==1 && $status_sol['status_tutor']==1) {
                        if (isset($date) && $date['state']==0 && $date['completado']==0){ 
                          $dateConf = dateTime($date['initDate'], " ");
                          $initDate = $dateConf[0]; $initTime = $dateConf[1]; 
                          $dateConf = dateTime($date['finishDate'], " ");
                          $finishDate = $dateConf[0]; $finishTime = $dateConf[1];
                          $time = timeComparer($initTime,$finishTime);
                          $nomen = dateTime($time,":");
                          ?>
                          <div class="card">
                            <div class="card-header">
                              Tiene una solicitud de cita.
                            </div>
                            <div class="card-body">
                              <h5 class="card-title">Detalles de la solicitud</h5>
                              <p class="card-text">Inicia el dia <strong><?php echo $initDate?></strong> a la hora <strong><?php echo $initTime?></strong> y termina el dia <strong><?php echo $finishDate?></strong> a la hora <strong><?php echo $finishTime?></strong></p>
                              <p>Si decide aceptar la cita se añadira <strong><?php echo $time." "; echo ($nomen[0]>0)?"horas":"minutos" ?></strong> a su historial. </p>
                              <button class="btn btn-success" onclick="jQuery('solDate', 1);" >Aceptar Solicitud</button>
                              <button class="btn btn-danger" onclick="jQuery('solDate', 2);" >Rechazar Solicitud</button>
                              <div id="ID_Mostrar_info"></div>
                            </div>
                          </div>
                      <?php  }
                      elseif ( isset($date) && ($date['status_tutor']==1 || $date['status_tutor']==0) ) { ?>
                          <div><i class="bi bi-calendar2-range"></i> Espera a que el alumno valide tu cita para recibir nuevas notificaciones del usuario</div>
                      <?php
                      }
                      if ( $date['state']==1 && $date['status_tutor'] == 3) {
                          $dateConf = dateTime($date['initDate'], " ");
                          $initDate = $dateConf[0]; $initTime = $dateConf[1]; 
                          $dateConf = dateTime($date['finishDate'], " ");
                          $finishDate = $dateConf[0]; $finishTime = $dateConf[1];
                          $fecha_entrada  = strtotime(($finishDate." ".$finishTime));
                          $fecha_actual = strtotime(date("Y-m-d H:i:00",time()));
                          if($fecha_actual > $fecha_entrada){
                            //echo "La fecha entrada ya ha pasado";
                      ?>
                          <div class="card">
                            <div class="card-header">
                              ¿Que tal tu reunion?
                            </div>
                            <div class="card-body">
                              <h5 class="card-title">¿La reunion se llevo a cabo?</h5>
                              <p class="card-text"></p>
                              <button class="btn btn-success" onclick="jQuery('solConf', 1);">Si todo bien!</button>
                              <button class="btn btn-danger" onclick="jQuery('solConf', 2);">No se presento</button>
                              <div id="ID_Mostrar_info"></div>
                            </div>
                          </div>
                      <?php
                          }else{
                            //echo "Aun falta algun tiempo"; ?>
                            <div><i class="bi bi-calendar2-range"></i> Tienes programa una cita para el <strong><?php echo $initDate?></strong> a las <strong><?php echo $initTime?></strong></div>
                        <?php }
                       } 
                      } ?>
                    </div>
                  </div>

<script>//e.preventDefault();</script>
<script src="./../Scripts/detailsFromDetails.js"></script>