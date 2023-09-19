<?php 
require ("./../include/User_session.php");
require ("./../include/config.php");
require ("./../include/query.php");
$userSession = new UserSession();
$dataSession=$userSession->getCurrentUser();

    $id = $_SESSION['id'];
    //print $id;
    $objConecion= new only_query();
    $sql= "SELECT solicitudes.id, solicitudes.id_user FROM solicitudes WHERE solicitudes.id_tutor =$id  AND solicitudes.status_tutor=1 AND solicitudes.status = 0;";
    $res=$objConecion->searchSql_Assoc($sql);
    //print_r ($res);
?>
  
      
<?php foreach ($res as $var) {

    $id_user =$var['id_user'];
    $id_chat =$var['id'];
    $sql= "SELECT Users.Name, Users.fname, Users.Url FROM Users WHERE Users.ID = $id_user;";
    $user_inf=$objConecion->searchSql_Assoc($sql);
    foreach ($user_inf as $Names_user){
        $Name = $Names_user['Name'];
        $fname = $Names_user['fname'];
        $url = ($Names_user['Url']== "")? "./../../storage/upload/icon_avatar.png" : $Names_user['Url'];
    }
    $sql= "SELECT txt, chat.user, tutor, chat.date FROM chat WHERE chat.id_sol = $id_chat AND chat.date = (SELECT MAX(chat.date )FROM chat WHERE chat.id_sol = $id_chat);";
    $chat_inf=$objConecion->searchSql_Assoc($sql);
    foreach ($chat_inf as $chat){
        $user = $chat['user'];
        $tutor = $chat['tutor'];
        $txt = $chat['txt'];
        $date = $chat['date'];
    }
    //print_r($chat_inf);
    $estilo = ($tutor== '1' && $user =='0')? "trans" : "" ;
    ?> 
    
<style> .trans::before{transform: scaleX(-1);} </style>
 <a href="details.php?id=<?php echo $id_user; ?>&token=<?php echo hash_hmac('sha1',$id_user,KEY_TOKEN);?>" style="color: black; text-decoration: none;">     
    <div class="row row-chat-box">
        <div class="col col-img">
        <img src="<?php echo $url; ?>" class="foto-perfil" alt="foto de perfil">
        </div>
        <div class="col col-details">
            <p class="name-chat"><?php echo $Name." ".$fname ?></p>
            <p class="texto-chat"><i class="bi bi-reply <?php echo $estilo ?>"></i><?php echo $txt; ?></p>
        </div>
        <div class="col col-date">
        <?php echo formatDate($date);?>
        </div>
    </div>
</a>



<?php }?>

