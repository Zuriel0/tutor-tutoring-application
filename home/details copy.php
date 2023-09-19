<?php include("Header.php"); ?>

<?php
 //require ("./../include/query.php");
 //require ("./../include/config.php");
 
  

function dateTime ($arg, $seps){
  $sep = $seps;
  $cad = $arg;
  $Separador = explode($sep, $cad);
  return $Separador;
}
function timeComparer ( $initTime, $finishTime ){
  $dateConf = dateTime($initTime,":");
  $dateConf2 = dateTime($finishTime,":");
  $horas = $dateConf2[0] - $dateConf[0];
  $min = $dateConf2[1] - $dateConf[1];
  $res = $horas.":".$min;
  return $res;
}
function adderTime($time, $time2){
  $time = dateTime($time,":");
  $time2 = dateTime($time2,":");
  $min = $time[1] + $time2[1];
  $acarreo = ($min>=60)?1:0;
  $min = ($min>=60)?($min-60):$min;
  $horas = $time[0] + $time2[0] + $acarreo;
  return $horas.":".$min;
}
function strip_param_from_url( $url, $param ) {
  $base_url = strtok($url, '?');              // Get the base url
  $parsed_url = parse_url($url);              // Parse it 
  $query = $parsed_url['query'];              // Get the query string
  parse_str( $query, $parameters );           // Convert Parameters into array
  unset( $parameters[$param] );               // Delete the one you want
  $new_query = http_build_query($parameters); // Rebuilt query string
  return $base_url.'?'.$new_query;            // Finally url is ready
}

 $id = isset($_GET['id']) ? $_GET['id'] : '';
 $token = isset($_GET['token']) ? $_GET['token'] : '';
 $w1 = isset($_GET['w1']) ? $_GET['w1'] : '';
 $w2 = isset($_GET['w2']) ? $_GET['w2'] : '';
 if ($id=='' || $token==''){
    echo "Error intente de new";
    exit;
 }else{
    $token_tmp= hash_hmac('sha1',$id, KEY_TOKEN);
    if ($token==$token_tmp){
        
        $objConecion= new only_query();
        $sql=$objConecion->connect()->prepare("SELECT count(ID) FROM Users Where ID=? AND  Tipo=1");
        $sql->execute([$id]);
        $userSession->setCurrentTutor($id);
        if ($sql->fetchColumn()> 0){

            $sql=$objConecion->connect()->prepare("SELECT Name, Escuela, Semestre, carrera, Url, Abstract FROM Users Where ID=? AND  Tipo=1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $name = $row['Name'];
            $escuela = $row['Escuela'];
            $semestre = $row['Semestre'];
            $abstract = $row['Abstract'];
            $carrera = $row['carrera'];
            $url = $row['Url'];
            
            

            $sql = "SELECT solicitudes.id, solicitudes.status_tutor, solicitudes.status_user, solicitudes.denied FROM solicitudes WHERE solicitudes.id_tutor = ".$dataSession['id']." AND solicitudes.id_user = ".$id.";";
            $status_sol = $objConecion->searchSql($sql);
            $_SESSION['id_chat'] = $status_sol['id'];
            $_SESSION['name_alum'] = $name;
            $_SESSION['url_alum'] = $url;
            //print_r ($status_sol);
            //print_r ($_GET);
            //print_r ($_SESSION);
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
              }elseif ($date['status_tutor'] == 1 && $date['status_user'] == 1) {
                $time = timeComparer($initTime,$finishTime);
                $sql = "SELECT tiempo FROM Users_tutores WHERE ID = ".$date['id_tutor']." ;";
                $inf_tutor = $objConecion->searchSql($sql);
                $tiempoo = $inf_tutor['tiempo'];
                $time = adderTime( $time, $inf_tutor['tiempo']);
                $sql = "UPDATE Users_tutores SET tiempo =  '$time'  WHERE Users_tutores.ID = ".$date['id_tutor']." ;";
                $objConecion->ejecSql($sql);
                $sql = "DELETE FROM dates WHERE id = ".$status_sol['id']." ;";
                $objConecion->executeSql($sql);
                $date = query_date_colcult($status_sol['id']);
              }

            }
            
            if($_GET['w1'] != ""){
              $sol = (isset($_POST['aceptar']))?$_POST['aceptar'] : "";
              $sql = "UPDATE `solicitudes` SET `status_tutor` = '1' WHERE solicitudes.id_user = ".$id." AND solicitudes.id_tutor = ".$dataSession['id'].";";
              $objConecion->ejecSql($sql);
              $status_sol = query_sol_status( $dataSession['id'], $dataSession['alumno'] );
              
              
            
            }elseif($_GET['w2'] != ""){
              $sol = (isset($_POST['deneid']))?$_POST['deneid'] : "";
              $sql = "UPDATE solicitudes SET status_user = 0, denied = 1 WHERE solicitudes.id_user = ".$id." AND solicitudes.id_tutor = ".$dataSession['id'].";";
              $objConecion->ejecSql($sql);
              $status_sol = query_sol_status( $dataSession['id'], $dataSession['alumno'] );
              header ('location: details.php?id='.$id.'&token='.$token);
            }
          }
          if($_GET['d1'] != ""){
            $sql = "UPDATE `dates` SET `state` = '1' WHERE dates.id = ".$status_sol['id']." ;";
            $objConecion->executeSql($sql);
            $date = query_date_colcult($status_sol['id']);
            $urlll = strip_param_from_url( 'https://anxzu.com/tutors/home/details.php?id=1&token=38d1712ed4a2fb0786d30f4c921bbb0ab282cc4d&d1=acp','d1' );
            header ('location:'.$urlll);
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

    }else{
        echo "Error intente de new";
        exit;
    }
 }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<div class="container">

        <div class="col" >
          <div class="card mb-3" style="max-width: auto;">
            <div class="row g-0">
              <div class="col-md-4">
                  <?php  
                      //$id= $var['ID'];
                      //$image = "./../include/upload/tutors/$id/ "
                      if($url==""){
                          $url= "./../include/upload/icon_avatar.png";
                      }
                  ?>
                <img src="<?php echo $url;?>" class="img-fluid rounded-start" alt="...">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $name;  ?></h5>
                  <p class="card-text"><strong>Escuela:</strong> <?php echo $escuela;?> <br/>
                  <strong>Semestre:</strong> <?php echo $semestre;?> <br/>
                    <strong>Carrera:</strong> <?php echo $carrera;?> <br/>
                    <strong>Abstract: </strong><?php echo $abstract;?> </p>
                  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                  <div class = "row align-items-end">
                    <div class="col-auto" id=""> 
                      <?php if($status_sol['status_tutor']==0 && $status_sol['status_user']==1){ ?>
                      <form action="" method="post" id="formulario">
                        <button type="submit" class="btn btn-success" name="aceptar" value="1" onclick="myFunction (1)" id="aceptar">Aceptar Solicitud</button>
                        <button type="submit" class="btn btn-danger" name="denied" value="1" onclick="myFunction (2)" id="denied">Rechazar Solicitud</button>
                      </form>
                      <?php } if($status_sol['denied']==1 && $status_sol['status_tutor']==0){ ?>
                        <a type="submit" class="btn btn-warning" href="tutorias.php?id=<?php echo $dataSession['id']; ?>&token=<?php echo hash_hmac('sha1',$dataSession['id'],KEY_TOKEN);?>" name="back"  id="">Volver a pagina anterior</a>
                      <?php  } if ($status_sol['status_user']==1 && $status_sol['status_tutor']==1) {
                        if (isset($date) && $date['state']==0){ 
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
                              <p>Si decide aceptar la cita se añadira <strong><?php echo $time." "; echo ($nomen>0)?"minutos":"horas" ?></strong> a su historial. </p>
                              <button type="submit" class="btn btn-success" name="aceptar" value="1" onclick="myFunction2 (1)" id="aceptar">Aceptar Solicitud</button>
                              <button type="submit" class="btn btn-danger" name="denied" value="1" onclick="myFunction2 (2)" id="denied">Rechazar Solicitud</button>
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
                              <button type="submit" class="btn btn-success" name="aceptar" value="1" onclick="myFunction3 (1)" id="aceptar">Si todo bien!</button>
                              <button type="submit" class="btn btn-danger" name="denied" value="1" onclick="myFunction3 (2)" id="denied">No se presento</button>
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
                </div>
              </div>
            </div>
          </div>
        </div>
        <script>
          setTimeout(
            function(){
            document.getElementById('chat').scrollTop=5000;},500);
        </script>
<?php print_r($status_sol);
print_r($date); ?>

<?php 
if($status_sol['status_tutor']==1 && $status_sol['status_user']==1){
  include_once "./../include/chat/index.php";

}
?>
<script src="./../Scripts/details.js"></script> 
</div>



</body>
</html>