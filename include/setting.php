
<?php 

function checkForm ($campo,$dato,$id){
    
    if ($dato != ""){
        $objConecion = new only_query();
        $sql = "UPDATE `Users_tutores` SET `".$campo."` = '".$dato."' WHERE `Users`.`ID` = ".$id.";";
        $objConecion->ejecSql($sql);
        
        //echo $campo." ". $dato. " ". $id."<br>";
    }


}

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';
 if ($id=='' || $token==''){
    echo "Error intente de new";
    exit;
 }else{
    $token_tmp= hash_hmac('sha1',$id, KEY_TOKEN);
    if ($token==$token_tmp){
        
        
        $objConecion= new only_query();
        $sql=$objConecion->connect()->prepare("SELECT count(ID) FROM Users_tutores Where ID=? AND  Tipo=1");
        $sql->execute([$id]);
        
        //print_r ($_POST);
        //print_r ($_FILES);

        if ($sql->fetchColumn()> 0){

            $sql=$objConecion->connect()->prepare("SELECT Name, fname, Mail, 'Numero de boleta', Url, Escuela, Abstract FROM Users_tutores Where ID=? AND  Tipo=1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $name = $row['Name'];
            $fname = $row['fname'];
            $escuela = $row['Escuela'];
            $url = $row['Url'];
            $semestre = $row['Semestre'];
            if($row['Abstract']==""){
                $abstract =  "Escibe acerca de ti...";
            }else{
                $abstract =$row['Abstract'];
            }
            
            if($_POST){

                $campo = array ( "1"  => "Name",
                    "2"  => "fname",
                    "3"  => "Escuela",
                    "4"  => "Abstract" 
                );
                $i=1;
                foreach($_POST as $dato){

                    checkForm($campo[$i],$dato,$dataSession['id']);
                    $i++;
                }

                if(isset($_FILES)){
                    //echo $campo[2];

                    $year = date("Y");
                    $month = date("m");
                    $directorio = "./../../storage/upload/users/".$year."/".$month."/"  ;
                    $aleatorio = mt_rand(100, 999);
                    $ruta = "./../../storage/upload/users/".$year."/".$month."/".$aleatorio;
                    
                    
                    $nombre=$_FILES['url']['name'];
    
                    $guardado=$_FILES['url']['tmp_name'];
                    
                    
                    if(!file_exists($directorio )){
                        mkdir($directorio ,0777,true);
                        if(file_exists($directorio )){
                    
                            if(move_uploaded_file($guardado, 'archivos/'.$nombre)){
                                //echo "Archivo guardado con exito";
                                $sql = "UPDATE `Users_tutores` SET `Url` = '".$ruta.".png' WHERE `Users`.`ID` = ".$dataSession['id'].";";
                                $objConecion->ejecSql($sql);
                            }else{
                                //echo "Archivo no se pudo guardar";
                            }
                        }
                    }else{
                            if(move_uploaded_file($guardado, $directorio.$aleatorio.".png")){
                            //echo "Archivo guardado con exito";
                            $sql = "UPDATE `Users_tutores` SET `Url` = '".$ruta.".png' WHERE `Users`.`ID` = ".$dataSession['id'].";";
                            $objConecion->ejecSql($sql);
                    
                        }elseif(move_uploaded_file($guardado, $directorio.$aleatorio.".pdf")){
                            //echo "Archivo guardado con exito";
                            $sql = "UPDATE `Users_tutores` SET `Url` = '".$ruta.".pdf' WHERE `Users`.`ID` = ".$dataSession['id'].";";
                            $objConecion->ejecSql($sql);
                        }else{
                            //echo "Archivo no se pudo guardar";
                        }
                    
                        //var_dump($ruta);
                    
                    }
                    
                }
            }
    
            
            //print_r ($status_sol);
            

        }

    }else{
        echo "Error intente de new";
        exit;
    }
 }

?>