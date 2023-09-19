

<?php 
require ("./../include/User_session.php");

$userSession = new UserSession();
$dataSession=$userSession->getCurrentUser();
//print_r($dataSession);


//print_r ($dataSession);

if(isset($dataSession['id']) && $dataSession['tipo']==1){
  //echo "hay sesion";
}elseif (isset($dataSession['id']) && $dataSession['tipo']==0) { 
  //echo "no hay sesion";
  header("location:./../home/form.php"); 
}else {
  header("location:./../index.php"); 
}
require ("./../include/query.php");
require ("./../include/config.php");
$objConecion= new only_query();
$data=query_data_tutores($dataSession['id']);

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicio</title>
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
</head>
<body>

<header class="p-3 mb-3 border-bottom header-fa" id="grupo__header" style="">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="Home.php" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
          <img src="./../../storage/upload/ipn_logo.png" alt="mdo" width="62" height="52">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li><a href="/tutors/home/Home.php" class="nav-link px-3 link-secondary">Todos</a></li>
            <li><a href="tutorias.php?id=<?php echo $dataSession['id']; ?>&token=<?php echo hash_hmac('sha1',$dataSession['id'],KEY_TOKEN);?>" class="nav-link px-3 link-secondary">Mis Alumnos</a></li>
  
        </ul>

        <i class="bi bi-bell-fill" style="padding-right: 27px; font-size: 25px;"></i>
        <?php 
          if($data['Url']==""){
            $url= "./../../storage/upload/icon_avatar.png";
        }else{
          $url=$data['Url'];
        }
        ?>
        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?php echo $url;?>" alt="mdo" width="45" height="45" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1"> <!--  Menu de usuario     -->
            <li><a class="dropdown-item" href="tutorias.php?id=<?php echo $dataSession['id']; ?>&token=<?php echo hash_hmac('sha1',$dataSession['id'],KEY_TOKEN);?>">Tutorias</a></li>
            <li><a class="dropdown-item" href="setting.php?id=<?php  echo $dataSession['id']; ?>&token=<?php echo hash_hmac('sha1',$dataSession['id'],KEY_TOKEN);?>">Configuracion</a></li>
            <li><a class="dropdown-item" href="profile.php?id=<?php  echo $dataSession['id']; ?>&token=<?php echo hash_hmac('sha1',$dataSession['id'],KEY_TOKEN);?>">Perfil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../include/Logout.php">Sign out</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>

<!------------------------------------------------ zona mobile ---------------------------------------->


<header id="grupo__header_mob">
  <nav class="navbar bg-light fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"> 
      <img src="./../../storage/upload/ipn_logo.png" alt="mdo" width="62" height="52">Servicio</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?php echo $url;?>" alt="mdo" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1"> <!--  Menu de usuario     -->
            <li><a class="dropdown-item" href="tutorias.php?id=<?php echo $dataSession['id']; ?>&token=<?php echo hash_hmac('sha1',$dataSession['id'],KEY_TOKEN);?>">Tutorias</a></li>
            <li><a class="dropdown-item" href="setting.php?id=<?php  echo $dataSession['id']; ?>&token=<?php echo hash_hmac('sha1',$dataSession['id'],KEY_TOKEN);?>">Configuracion</a></li>
            <li><a class="dropdown-item" href="profile.php?id=<?php  echo $dataSession['id']; ?>&token=<?php echo hash_hmac('sha1',$dataSession['id'],KEY_TOKEN);?>">Perfil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../include/Logout.php">Sign out</a></li>
          </ul>
        </div>
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>

          
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/tutors/home/Home.php">Todos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Mis Alumnos</a>
            </li>
          </ul>
          <form class="d-flex" role="search">
            <input class="form-control me-2" id="search-from" onkeypress="search()" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </div>
  </nav>
  <br><br><br><br>
</header>


  <script>
        let navegador = navigator.userAgent;
        if (window.innerWidth <= 768) {
            console.log("Es un móvil");
            document.getElementById(`grupo__header`).classList.add('head_block');
        }else{
          document.getElementById(`grupo__header_mob`).classList.add('head_block');
        }
  </script>
  <script src="./../Scripts/header.js"></script>
  <script src="./../Scripts/search-from.js"></script> 
    

  


