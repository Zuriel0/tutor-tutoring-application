<?php include("./../query.php"); ?>

<?php 
require ("./../User_session.php");           
$userSession = new UserSession();
$dataSession=$userSession->getCurrentUser();

//echo "funciono";


$txt = isset($_POST['txt'])? $_POST['txt'] :"";
 if (isset($_POST['txt'])){
   $objConecion= new only_query();
   $sql = "INSERT INTO `chat` (`id_sol`, `user`, `tutor`, `txt`, `date`) VALUES ('". $_SESSION['id_chat']."', '0', '1', '".$txt."', current_timestamp());";
   $objConecion->ejecSql($sql);
   $txt = "";
 }


?>