<?php include("Header.php"); ?>
<?php require ("./../include/setting.php");?>



<div class="container">

<form action="setting.php?id=<?php  echo $dataSession['id']; ?>&token=<?php echo hash_hmac('sha1',$dataSession['id'],KEY_TOKEN);?>" method="post" enctype="multipart/form-data" id="formulario">
    <div class="row">
    <div class="col">
        <strong>Nombre:</strong><input type="text" name="name" class="form-control" placeholder="<?php echo $name;?>" aria-label="First name" id="names">
    </div>
    <div class="col">
    <strong>Apellido:</strong><input type="text" name="fname" class="form-control" placeholder="<?php echo $fname;?>" aria-label="Last name" id="fname">
    </div>
    </div>
    <div class="row">
        <div class="col">
            <strong>Escuela:</strong>
            <select class="form-select" name="escuela" aria-label="Default select example" id="escuela">
            <option selected>Selecciona tu escuela</option>
            <option value="Esime Zacatenco">Esime Zacatenco</option>
            <!-- <option value="Esime Azcatpozalco">Esime Azcatpozalco</option>
            <option value="Esime Culhuacan">Esime Culhuacan</option>
            <option value="Esime Ticoman">Esime Ticoman</option> -->
            </select>
        </div>
    </div>
    <div class="row">
        <div class="mb-3">
            <strong>Abstract:</strong>
            <textarea class="form-control" name="abstract" id="exampleFormControlTextarea1" placeholder="<?php echo $abstract; ?>" rows="3" id="texto"></textarea>
        </div>
    </div>
    <div class="row g-0">
              <div class="col-md-2">
                  <?php  
                      //$id= $var['ID'];
                      //$image = "./../include/upload/tutors/$id/ "
                      if($url==""){
                          $url= "./../../storage/upload/icon_avatar.png";
                      }
                  ?>
                <p><strong>Foto de perfil</strong></p>
                <img src="<?php echo $url;?>" class="img-fluid rounded-start" alt="..." width="100" height="100" id="url">
     </div>
     <div class="col-md-8 ">
        <div class="mb-3 align-items-center">
            
            <input class="form-control" name="url" style="" type="file" id="formFile">
        </div>
    </div>
    <div class="row">
        <button class="btn btn-success">Actualizar Informacion</button>

    </div>
</form>

</div>


<script src="./../Scripts/setting.js"></script>
</body>
</html>