<?php 

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
        
        //print_r ($_GET);

        if ($sql->fetchColumn()> 0){

            $sql=$objConecion->connect()->prepare("SELECT Name, fname, Mail, 'Numero de boleta', Url, Escuela, Abstract FROM Users_tutores Where ID=? AND  Tipo=1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $name = $row['Name'];
            $fname = $row['fname'];
            $escuela = $row['Escuela'];
            $semestre = $row['Semestre'];
            $abstract = $row['Abstract'];
            

            
            //print_r ($status_sol);
            

        }

    }else{
        echo "Error intente de new";
        exit;
    }
 }

?>