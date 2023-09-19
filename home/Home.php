<?php include("Header.php");
include("./../include/home.php");

?>

<style> .header-fa{margin-bottom: 0px !important;} </style>


<body onload="ajax();">
  <div class="container-fluid contaner-home" style="">
    <div class="row row-home">
      <div class="col col-chat-gen" style="">
        <div class="row" style="background-color: #D7D5D7">
          <div class="col col-chat-search" >
            <div class="row">
              <div class="col">
              <i class="bi bi-search"></i>
              </div>
              <div class="col search-box ">
                <input type="text" class="search" name="chat" placeholder="Search" id="">
              </div>
            </div>
          </div>
        </div>
        <div id="chat">

          <!-- <div class="row row-chat-box">
            <div class="col col-img">
              <img src="../include/upload/users/2022/07/232.png" class="foto-perfil" alt="foto de perfil">
            </div>
            <div class="col col-details">
                <p class="name-chat">Andres Zuriel Macias Rios</p>
                <p class="texto-chat"><i class="bi bi-reply"></i>hola muchacho</p>
            </div>
            <div class="col col-date">
              11:12
            </div>
          </div> -->


        </div>
      </div>
      <div class="col dashboard-menu">
        <div class="row">
          <div class="col">
            <canvas id="grafica"></canvas>
          </div>
          <div class="col dashboard">
            <div class="row">
              <div class="col">
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#newMod">
                  <div class="col col-dashboar">
                    <div class="col point">
                      <i class="circule" style="background-color: green;"></i>                  
                    </div>
                    <div class="col num-cont" value="<?php echo $cal['tutorias_completadas'];?>" id="tutoCompletas">
                    <?php echo $cal['tutorias_completadas'];?> 
                    </div>
                    <div class="col txt-cont">
                      Tutorias Completadas 
                    </div>
                  </div>
                </a>
                <div class="col col-dashboar">
                  <div class="col point">
                    <i class="circule" style="background-color: orange;"></i>                  
                  </div>
                  <div class="col col-dates">
                    <div class="row">
                      Tu siguiente reunion es:
                    </div>
                    <div class="row">
                      <?php echo isset($dateTime[0])?$dateTime[0] :"No tienes reuniones programadas"; ?>
                    </div>
                  </div>
                </div>
              </div>
                
                <div class="col">
                  <div class="col col-dashboar-average">
                    <div class="col average-total">
                      <div class="quality-gen">Calidad General</div>
                      <div class="Num-quality"><?php echo is_int($dificultad)?number_format($calificacion,1):0;?></div>
                    </div>
                    <div class="col">
                      <div class="col average-par" style="border-bottom: 1px solid gray;">
                        <div class="recomendation-gen">Lo recomiendan</div>
                        <div class="Num-recomendation"><?php echo is_int($dificultad)?number_format($recomendacion,1):0;?>%</div>
                      </div>
                      <div class="col average-par">
                        <div class="recomendation-gen" style="font-size: 13px;">Nivel de dificultad</div>
                        <div class="Num-recomendation"><?php echo is_int($dificultad)?number_format($dificultad,1):0;?></div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          
          <!-- <div class="col col-dashboar-average">
            <div class="col average-total">
              1 of 2
            </div>
            <div class="col average-par">
              <div class="col average-par"></div>
                1 of 2
              </div>
            </div>
          </div>   -->
        </div>
      </div>
    </div>
  </div>

<script src="../Scripts/home.js"></script>
<!-- <script src="../Scripts/charts.js"></script> -->
<script>
  const $grafica = document.querySelector("#grafica");
// Las etiquetas son las que van en el eje X. 
const etiquetas = ["<?php echo mont($mont,$mont_act,4);?>", "<?php echo mont($mont,$mont_act,3);?>", "<?php echo mont($mont,$mont_act,2);?>", "<?php echo mont($mont,$mont_act,1);?>","<?php echo mont($mont,$mont_act,0);?>"]
// Podemos tener varios conjuntos de datos. Comencemos con uno
const datosVentas2020 = {
    label: "Alumnos por mes",
    data: [0, 0, 0, 0, <?php echo $cal['tutorias_completadas'];?> ], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
    borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
    borderWidth: 1,// Ancho del borde
};
new Chart($grafica, {
    type: 'bar',// Tipo de gráfica
    data: {
        labels: etiquetas,
        datasets: [
            datosVentas2020,
            // Aquí más datos...
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }],
        },
    }
});
const myModal = document.getElementById('myModal');
const myInput = document.getElementById('myInput');

myModal.addEventListener('shown.bs.modal', () => {
  myInput.focus();
});
</script>

<!-- Modal calendario -->
<div class="modal fade" style="--bs-modal-width: 550px;" id="newMod" tabindex="-1"  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalles de tutorias</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="post" id="formulario-date">
        <div class="modal-body" id="calendar" > 
          <div class="col" >
            <?php
            if(isset($dates_chek)){?>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Alumno</th>
                  <th scope="col">Fecha</th>
                  <th scope="col">Tiempo</th>
                </tr>
              </thead>
              <tbody>
              <?php $plus=1;
               foreach ($dates as $key ) {
                $sql= "SELECT * FROM Users WHERE ID = ".$key['id_tutor'].";";
                $alumno = $objConecion->searchSql($sql);
                ?>
                <tr>
                  <th scope="row"><?php echo $plus++ ?></th>
                  <td><?php echo $alumno['Name'];?></td>
                  <td><?php echo $key['initDate'];?></td>
                  <td><?php echo $key['tiempo'];?></td>
                </tr>
                <?php } ?>
                <tr>
                  <th scope="row"></th>
                  <td>Tiempo total</td>
                  <td></td>
                  <td><?php echo $data['tiempo'];?></td>
                </tr>
              </tbody>
            </table>
          </div>
          <?php }else{ ?>
            <figure class="text-center">
              <blockquote class="blockquote">
                <p>De momento no tiene ninguna sesion concluida.</p>
              </blockquote>
              <figcaption class="blockquote-footer">
                <!-- Someone famous in <cite title="Source Title">Source Title</cite> -->
              </figcaption>
            </figure>
          <?php }?> 
        </div> 
      </form>
    </div>
  </div>
</div>

</body>
</html>






<?php //include("Footer.php"); ?>