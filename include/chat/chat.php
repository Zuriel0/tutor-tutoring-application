<?php include("./../query.php"); ?>
<?php 
            require ("./../User_session.php");
            
            $userSession = new UserSession();
            $dataSession=$userSession->getCurrentUser();
           
            $chat = query_chat_info( $dataSession['id'], $dataSession['alumno'], $dataSession['id_chat']);
            //print_r ($chat);
            //print_r($dataSession);
            foreach($chat as $var){ 
              
              if ($var['user'] == 1) {
          ?>

            <div class="d-flex justify-content-between">
              <p class="small mb-1"><?php echo  $_SESSION['name_alum'];?></p>
              <p class="small mb-1 text-muted"><?php echo formatDate($var['date']);?></p>
            </div>
            <div class="d-flex flex-row justify-content-start">
              <img src="<?php echo  $_SESSION['url_alum'];?>"
                alt="<?php echo  $_SESSION['name_alum'];?>" style="width: 45px; height: 100%; border-radius: 35px;">
              <div>
                <p class="small p-2 ms-3 mb-3 rounded-3" style="background-color: #f5f6f7;"><?php echo $var['txt'];?></p>
              </div>
            </div>
                <?php }elseif($var['tutor']){ ?>
            <div class="d-flex justify-content-between">
              <p class="small mb-1 text-muted"><?php echo formatDate($var['date']);?></p>
              <p class="small mb-1">Tu</p>
            </div>
            <div class="d-flex flex-row justify-content-end mb-4 pt-1">
              <div>
                <p class="small p-2 me-3 mb-3 text-white rounded-3 bg-warning"><?php echo $var['txt'];?></p>
              </div>
              <?php 
                if($dataSession['url']==""){
                  $url= "./../../storage/upload/icon_avatar.png";
              }else{
                $url=$dataSession['url'];
              }
              ?>
              <img src="<?php echo $url;?>"
                alt="avatar 1" style="width: 45px; height: 100%; border-radius: 35px">
            </div>
            <?php }} ?>