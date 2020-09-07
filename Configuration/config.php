<?php
/*
* Created by PhpStorm.
* User: Bilal Rehman
*/
    session_start();
    $config = [
        "URL" => 'http://'.$_SERVER['HTTP_HOST'].'/ParagonCMS',
        "last_URL" =>  substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '/') + 1),
    ];

    //echo $config['URL'];

    $page = explode('.',$config['last_URL'])[0];

    //echo $page;
        if (isset($_REQUEST['nav'])):
            if (!file_exists('pages/'.$_REQUEST['nav'].'.php')):
                header('location: 404');
            else:
                $page = 'pages/'.$_REQUEST['nav'].'.php';
            endif;
        else:
            $page = 'pages/main-content.php';
        endif;
    function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, strlen($alphabet)-1);
            $pass[$i] = $alphabet[$n];
        }
        return $pass;
    }
    function createNotification($sender,$notification,$case,$franchise,$reciever="Admission"){
        $db_handle = new DBController();
        $conn = $db_handle->connection();
        if ($reciever!="Admission"){
            $query = "INSERT INTO `notifications`(`recipient_id`,`sender_id`,`type`,`reference_id`) VALUES (?,?,?,?)";
            $results = $db_handle->insert($query, 'iisi', array($reciever,$sender,$notification,$case ));
        }else{
            $query = $conn->query("SELECT `id` FROM `users` WHERE `role_id`=4 and `city_id`=".(int)$franchise);
            if ($query->num_rows>0){
                while($d = $query->fetch_assoc()):
                    $recieverId =  $d['id'];
                    $q = "INSERT INTO `notifications`(`recipient_id`,`sender_id`,`type`,`reference_id`) VALUES(?,?,?,?)";
                    $results = $db_handle->insert($q, 'iisi', array($recieverId,$sender,$notification,$case ));
                endwhile;
            }
        }
    }
?>