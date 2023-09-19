<?php include("Header.php"); ?>

<?php
 //require ("./../include/query.php");
 //require ("./../include/config.php");
 
  



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
            
            

          }
          
    }else{
        echo "Error intente de new";
        exit;
    }
 }
?>


    
<div class="container" onload="cardDetails();">

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
                  <div id="details">

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script>
    
        </script>
<?php //print_r($status_sol);
//print_r($date); ?>

<?php 
if($status_sol['status_tutor']==1 && $status_sol['status_user']==1){
  include_once "./../include/chat/index.php";

}
?>
<script src="./../Scripts/details.js"></script> 
 <script src="./../Scripts/detailsFromDetails.js"></script>
</div>



</body>
</html>