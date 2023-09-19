<?php include("Header.php"); ?>
<?php require ("./../include/profile.php");?>


    
<div class="container">

        <div class="col" >
          <div class="card mb-3" style="max-width: auto;">
            <div class="row g-0">
              <div class="col-md-4">
                  <?php  
                    if($row['Url']==""){
                        $url= "./../include/upload/icon_avatar.png";
                    }else{ $url= $row['Url'];}
                  ?>
                <img src="<?php echo $url;?>" class="img-fluid rounded-start" alt="...">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $name." ".$fname;  ?></h5>
                  <p class="card-text"><strong>Escuela:</strong> <?php echo $escuela;?> <br/>
                  <strong>Semestre:</strong> <?php echo $semestre;?> <br/>
                    <strong>Abstract: </strong><?php echo $abstract;?> </p>
                  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                  
                </div>
              </div>
            </div>
          </div>
        </div>



</div>


</body>
</html>