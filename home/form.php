<?php
require ("./../include/User_session.php");
require ("./../include/query.php");
//require("./../include/form.php");
$userSession = new UserSession();
$dataSession=$userSession->getCurrentUser();
$objConecion= new only_query();
$sql= "SELECT * FROM Materia ";
$materia = $objConecion->searchSql_Assoc($sql);
$sql= "SELECT * FROM semestres ";
$semestre = $objConecion->searchSql_Assoc($sql);

/*$sql = "SELECT * FROM Mat_User WHERE ID_Tutores = 1;";
$mat_user = $objConecion->searchSql_Assoc($sql);
foreach($mat_user as $mat){
  echo $mat['ID_Materias'];
}*/
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="./../Styles/virtual-select.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./../Styles/style.css">
  <link rel="stylesheet" href="./../Styles/header.css">
  <link rel="stylesheet" href="./../Styles/search-from.css">
  <link rel="stylesheet" href="./../Styles/home.css">
  <title>Registro</title>
</head>
<body>

<div class="" id="ID_Mostrar_info">

</div>
<div class="container">
    <div class="row">
        <div class="col">
          <form action="./../include/form.php" method="post" id="regInit">
            <div class="mb-3">
            <label for="semestre" class="form-label">¿En que semestre te encuentras?</label>
            <select class="form-select" name="semestre" aria-label="Default select example" id="semestre">
              <option selected>Selecciona tu opcion</option>
              <?php foreach($semestre as $semes){  ?>  
              <option value="<?php echo $semes['Semestre_ID'];?>"><?php echo $semes['Name'];?></option>
              <?php } ?>
            </select>
            </div>
            <div class="mb-3">
              <label  class="form-label">Horarios de atención de:</label>
              <input type="time" name="etaInit"rows="3"> a <input type="time" name="etaFinist"rows="3"> 
            </div>
            <div class="mb-3">
              <label for="abstrac" class="form-label">Cuentanos de ti</label>
              <textarea class="form-control" name="abstrac" id="abstrac" placeholder="Esto se vera en la descripcion de tu peril para que sea mas probable que te eligan como tutor" rows="3"></textarea>
            </div>
            <div class="mb-3">
            <label for="multipleselect" class="form-label">Materias que pueden impartir</label>
            <select multiple name="native-select" placeholder="Native Select" data-silent-initial-value-set="false" id="multipleselect" style="border-radius">
              <?php foreach($materia as $mat){  ?>  
              <option value="<?php echo $mat['MateriaID'];?>"><?php echo $mat['Materia_Name'];?></option>
              <?php } ?>
            </select>
            </div>
            <button type="submit" class="btn btn-success" id="popoverButton">Guardar</button>
          </form>
        </div>
    </div>
</div>    

<script src="./../Scripts/formInit.js"></script>
<script type ="text/javascript" src="./../Scripts/virtual-select.min.js"></script>
<script type ="text/javascript">
  
  VirtualSelect.init({
    ele: '#multipleselect'
  });

</script>



  
</body>
</html>
