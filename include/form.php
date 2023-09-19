<?php
require ("./../include/User_session.php");
require ("./../include/query.php");

function dateTime ($arg, $seps){
  $sep = $seps;
  $cad = $arg;
  $Separador = explode($sep, $cad);
  return $Separador;
}

$objConecion= new only_query();
$userSession = new UserSession();
$dataSession=$userSession->getCurrentUser();
$id_temp = $dataSession['id'];
$sql = "SELECT * FROM Mat_User WHERE ID_Tutores = $id_temp;";
//  $mat_user = $objConecion->searchSql_Assoc($sql);
$horario = $_POST['etaInit']." ".$_POST['etaFinist'];

if(isset($_POST['semestre']) && isset($_POST['abstrac'])){
  $semes = $_POST['semestre'];
  $abst = $_POST['abstrac'];
  $sql = "UPDATE Users_tutores SET Semestre = $semes, Abstract = '$abst', horario ='$horario', Tipo = 1  WHERE ID = $id_temp; ";
  $objConecion->ejecSql($sql);
  header('location:./../home/Home.php');
}
if(isset($_POST['native-select'])){
  $sep = dateTime($_POST['native-select'],',');
  foreach($sep as $se){
    $sql = "INSERT INTO Mat_User (`ID_Materias`, `ID_Tutores`) VALUES ('$se', '$id_temp');"; 
    $objConecion->ejecSql($sql); 
    
  }
}

?>