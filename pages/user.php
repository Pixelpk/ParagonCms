<?php
if ($logged_in_user_data["role_id"]!=1){
    echo "<script>window.location='404';</script>";
}
if (isset($_SESSION['most_recent_activity']) &&
    (time() -   $_SESSION['most_recent_activity'] > 5)) {
    //600 seconds = 10 minutes
    unset($_SESSION['message']);
}

    $query = 'SELECT `id`,`name` FROM `franchise`';
    $franchises = $conn->query($query);
    $query = 'SELECT `id`,`role`,`permissions` FROM `roles`';
    $roles = $conn->query($query);
    if (isset($_POST['add'])):
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $role = $_POST['role'];
        $franchise = $_POST['franchise'];
        if ($role==1):
            $_SESSION['message'] = ["Super Admin cannot be Added , Contact Developer","danger"];
        else:
            $passwords = implode("",randomPassword()) ;
            $password = password_hash($passwords,PASSWORD_DEFAULT);
            $query = "INSERT INTO `users`(`name`,`email`,`phone`,`address`,`password`,`role_id`,`city_id`) VALUES(?,?,?,?,?,?,?)";
            $results = $db_handle->insert($query, 'sssssii', array($name,$email,$phone,$address,$password,$role,$franchise));
            if ($results):
                //Server settings
                $mail->isSMTP();                                            // Set mailer to use SMTP
                $mail->smtpDebug = 3;
                $mail->Host = 'mail.theskillsleader.com';                    // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                                   // Enable SMTP authentication
                $mail->Username = 'tester@theskillsleader.com';                     // SMTP username
                $mail->Password = 'tester@theskillsleader';                               // SMTP password
                $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 465;                                    // TCP port to connect to
                $mail->smtpConnect(
                    array(
                        "ssl" => array(
                            "verify_peer" => false,
                            "verify_peer_name" => false,
                            "allow_self_signed" => true
                        )
                    )
                );
                //Recipients
                $mail->setFrom('tester@theskillsleader.com', 'Support Admin');
                $mail->addAddress($email, $name);     // Add a recipient
                $mail->addCC('bilal.rehman000@hotmail.com');               // Name is optional
                //$mail->addReplyTo($email, $first_name . " " . $last_name);
                $mail->addCC('lookingforanas@gmail.com');
                //$mail->addBCC('bcc@example.com');

                // Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->XMailer = ' ';
                $mail->CharSet = 'utf-8';
                $mail->Subject = 'Successfully Registered User: '.$name;
                //$mail->Body = "<h1>Hello : ".$first_name." ".$middle_name." ".$last_name."</h1><br>";
                //$mail->Body .= '<h2>User Name: '.$first_name." ".$middle_name." ".$last_name.' </h2><br>';
                //$mail->Body .= 'In Order to activate your account: Please Click the link Below to setup your password and start using Matrix Gym Member Dashboard<br>';
                $mail->Body .= 'Successfully Registered for Paragon CMS; Your account has been created; You Credentials are as follows:  <br>';
                $mail->Body .= 'Email: <b>'.$email.'</b><br>';
                $mail->Body .= 'Password: <b>'.$passwords.'</b><br>';

                //$mail->Body .= ' <a href="https://bodyworkcloud.com/index.php?nav=verifyToken&verify=' . $verifyToken . '">https://bodyworkcloud.com/index.php?nav=verifyToken&verifyToken=' . $verifyToken . '</a>  <br>';
                $mail->Body .= 'Should you need any support; please contact us on <a href="mailto:info@pixelpk.com">info@pixelpk.com</a>.<br>';
                $mail->Body .= '<b>Thank You</b><br>';
                $mail->Body .= '<b>Paragon Overseas Consultants</b> <br>';

                if ($mail->send()):
                    echo '<script>alert("' . 'Successfully Registered New User: Confirmation Message has been sent' . '");</script>';
                    $_SESSION['most_recent_activity'] = time();
                    $_SESSION['message'] = ["Successfully Added the User\n Password for new User is ".$passwords." \n Save the Password In case He doesn't Receive the Email","success"];
                    echo "<script>window.location='index?nav=user';</script>>";
                else:
                    echo '<script>alert("' . "Successfully Registered :Message could not be sent. Contact PixelPK Administration for your account information. Mailer Error: {$mail->ErrorInfo}" . '");</script>';
                endif;
            else:
                echo '<script>alert("' . $conn->error . '");</script>';
            endif;
        endif;
    endif;
?>

<div class="row">
    <div class="col-md-12">
        <div class="text-left" style="float:left;">
            <a href="javascript:history.back()" class="btn btn-info btn-sm"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="clearfix"><br></div>
    </div>

    <div class="col-md-6 offset-md-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add User Profile</h4>
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?=$_SESSION['message']['1']?>">
                        <p><?=$_SESSION['message'][0];?></p>
                    </div>

                <?php endif;?>
                <form method="POST">
                    <div class="form-group has-inverse">
                        <label for="input-states-1"><?php ?><i class="far fa-user item-icon item-icon-right"></i> Name</label>
                        <div class="form-with-icon">
                            <input type="text" class="form-control" id="input-states-1" name="name"  >

                        </div>
                    </div>
                    <div class="form-group has-inverse">
                        <label for="input-states-2"><?php ?><i class="far fa-envelope item-icon item-icon-right"></i> Email</label>
                        <div class="form-with-icon">
                            <input type="email" class="form-control" id="input-states-2" name="email" >

                        </div>
                    </div>
                    <div class="form-group has-inverse">
                        <label for="input-states-3"><?php ?><i class="fas fa-phone item-icon item-icon-right"></i> Phone</label>
                        <div class="form-with-icon">
                            <input type="tel" class="form-control" id="input-states-3" name="phone" >

                        </div>
                    </div>
                    <div class="form-group has-inverse">
                        <label for="input-states-4"><?php ?><i class="far fa-address-card item-icon item-icon-right"></i> Address</label>
                        <div class="form-with-icon">
                            <input type="text" class="form-control" id="input-states-4" name="address"  >

                        </div>
                    </div>
                    <div class="form-group has-success">
                        <label for="input-states-5"><i class="far fa-building item-icon item-icon-right"></i> Franchise</label>

                        <div class="form-with-icon">
                            <select required name="franchise" class="form-control" id="input-states-5">
                                <option class="text-bold text-info" disabled>Franchise</option>
                                <?php while($data = $franchises->fetch_assoc()):?>
                                    <option value="<?=$data['id']?>"><?=$data['name']?></option>
                                <?php endwhile;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group has-success">
                        <label for="input-states-7"><i class="fas fa-user-lock item-icon item-icon-right"></i> Role</label>

                        <div class="form-with-icon">
                            <select required name="role" class="form-control" id="input-states-7">
                                <option class="text-bold text-info" disabled>Roles</option>
                                <?php while($data = $roles->fetch_assoc()):?>
                                    <option value="<?=$data['id']?>"><?=$data['role']?></option>
                                <?php endwhile;?>
                                <i class="fa fa-check item-icon item-icon-right"></i>
                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn btn-info btn-sm waves-effect waves-light" name="add" value="Add User Profile" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>