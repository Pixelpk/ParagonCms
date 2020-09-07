<?php
if ($logged_in_user_data["role_id"]==4){
    echo "<script>window.location='404';</script>";
}
$db_handle = new DBController();
$conn = $db_handle->connection();

$query = 'SELECT `id`,`name` FROM `countries`';
$country = $conn->query($query);

$query = 'SELECT `id`,`name` FROM `universities`';
$university = $conn->query($query);

$query = 'SELECT `id`,`name` FROM `franchise`';
$franchises = $conn->query($query);

if (isset($_POST['student_case'])):
    $student_name = $_POST['student_name'];
    $student_email = $_POST['student_email'];
    $student_phone = $_POST['student_phone'];
    $student_qualification = $_POST['student_qualification'];
    $student_cnic = $_POST['student_cnic'];
    $student_passport = $_POST['student_passport'];
    $student_courses = $_POST['student_courses'];
    $franchiseStudent = $_POST["franchises"];
    $countries="";
    $universities="";
    foreach($_POST['countries'] as $c):
        $countries.= $c.",";
    endforeach;
    foreach($_POST['universities'] as $c):
        $universities.= $c.",";
    endforeach;
    $case_generated = (int)$logged_in_user_data["id"];
    $query = "INSERT INTO `student_case` (`name`,`email`,`phone`,`qualification`,`universities`,`countries`,`case_generated_by`,`cnic`,`franchise`,`passport`,`courses`) values (?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";
    $results = $db_handle->insert($query, 'ssssssisiss', array($student_name,$student_email,$student_phone,$student_qualification,$universities,$countries,$case_generated,$student_cnic,$franchiseStudent,$student_passport,$student_courses ));
//    var_dump($results);
    if ($results):
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
            $mail->Body .= 'Successfully Registered a New Case in Paragon CMS; Credentials are as follows:  <br>';

            $mail->Body .= 'Name: <b>'.$student_name.'</b><br>';
            $mail->Body .= 'Email: <b>'.$student_email.'</b><br>';
            $mail->Body .= 'Phone: <b>'.$student_phone.'</b><br>';
            $mail->Body .= 'Qualification: <b>'.$student_qualification.'</b><br>';
            $mail->Body .= 'Passport: <b>'.$student_passport.'</b><br>';
            $mail->Body .= 'Interested Courses: <b>'.$student_courses.'</b><br>';
            $mail->Body .= 'Should you need any support; please contact us on <a href="mailto:info@pixelpk.com">info@pixelpk.com</a>.<br>';
            $mail->Body .= '<b>Thank You</b><br>';
            $mail->Body .= '<b>Paragon Overseas Consultants</b> <br>';

            if ($mail->send()):
                echo '<script>alert("' . 'Successfully Registered New Case: Confirmation Message has been sent to Admission Department' . '");</script>';
                $_SESSION['most_recent_activity'] = time();
                $_SESSION['message'] = ["Successfully Added the User\n Password for new User is ".$passwords." \n Save the Password In case He doesn't Receive the Email","success"];
                echo "<script>window.location='index?nav=user';</script>>";
            else:
                echo '<script>alert("' . "Successfully Registered :Message could not be sent. Contact PixelPK Administration for your account information. Mailer Error: {$mail->ErrorInfo}" . '");</script>';
            endif;
        else:
            echo '<script>alert("' . $conn->error . '");</script>';
        endif;
        $message = ["Student Case Added Successfully","success"];
    else:
        $message = ["Error in Inserting Data","danger"];
    endif;
endif;
?>
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="text-left" style="float:left;">
            <a href="javascript:history.back()" class="btn btn-info btn-sm"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="text-right">
            <a href="<?=$config['URL']?>/index?nav=student-cases" class="btn btn-info btn-sm">View All Student Cases</a>
        </div>
    </div>


    <div class="col-md-8 offset-md-2 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Initiate a Student Case</h4>
                <?php if (isset($message)): ?>
                    <div class="alert alert-<?=$message['1']?>">
                        <p><?=$message[0];?></p>
                    </div>
                <?php endif;?>
                <form method="POST">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group has-inverse">
                                <label for="input-states-4"><?php ?><i class="far fa-user item-icon item-icon-right"></i> Name Of Student</label>
                                <div class="form-with-icon">
                                    <input required type="text" class="form-control" id="input-states-4" name="student_name" placeholder="Enter...">
                                </div>
                            </div>
                            <div class="form-group has-inverse">
                                <label for="input-states-3"><?php ?><i class="far fa-envelope item-icon item-icon-right"></i> Email Of Student</label>
                                <div class="form-with-icon">
                                    <input required type="email" class="form-control" id="input-states-3" name="student_email" placeholder="Enter...">

                                </div>
                            </div>
                            <div class="form-group has-inverse">
                                <label for="input-states-2"> <?php ?><i class="fa fa-phone item-icon item-icon-right"></i> Phone Number Of Student</label>
                                <div class="form-with-icon">
                                    <input required type="tel" class="form-control" id="input-states-2" name="student_phone" placeholder="Enter...">

                                </div>
                            </div>
                            <div class="form-group has-inverse">
                                <label for="input-states-6"><?php ?><i class="fas fa-graduation-cap item-icon item-icon-right"></i> Qualification Of Student</label>
                                <div class="form-with-icon">
                                    <input required type="tel" class="form-control" id="input-states-6" name="student_qualification" placeholder="Enter...">

                                </div>
                            </div>
                            <div class="form-group has-inverse">
                                <label for="input-states-7"><?php ?><i class="far fa-id-card item-icon item-icon-right"></i> CNIC Of Student</label>
                                <div class="form-with-icon">
                                    <input type="tel" class="form-control" id="input-states-7" name="student_cnic" placeholder="Enter...">

                                </div>
                            </div>
                            <div class="form-group has-inverse">
                                <label for="input-states-9"> <?php ?><i class="fas fa-passport item-icon item-icon-right"></i> Passport Of Student</label>
                                <div class="form-with-icon">
                                    <input required type="tel" class="form-control" id="input-states-9" name="student_passport" placeholder="Enter...">

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group has-success">
                                <label for="input-states-1"><i class="fas fa-globe item-icon item-icon-right"></i> Country</label>

                                <div class="form-with-icon">
                                    <select required name="countries[]" class="form-control" id="input-states-1" multiple>
                                        <option class="text-bold text-info" disabled>Student Prefered Countries</option>
                                        <?php while($data = $country->fetch_assoc()):?>
                                            <option value="<?=$data['id']?>"><?=$data['name']?></option>
                                        <?php endwhile;?>
                                        <i class="fa fa-check item-icon item-icon-right"></i>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group has-success">
                                <label for="input-states-0"><i class="fas fa-university item-icon item-icon-right"></i> Universities</label>

                                <div class="form-with-icon">
                                    <select required name="universities[]" class="form-control" id="input-states-0" multiple>
                                        <option class="text-bold text-info" disabled>Student Prefered Universities</option>
                                        <?php while($data = $university->fetch_assoc()):?>
                                            <option value="<?=$data['id']?>"><?=$data['name']?></option>
                                        <?php endwhile;?>
                                        <i class="fa fa-check item-icon item-icon-right"></i>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group has-inverse">
                                <label for="input-states-10"> <?php ?><i class="fas fa-paragraph item-icon item-icon-right"></i> Interested Courses</label>
                                <div class="form-with-icon">
                                    <textarea required class="form-control" id="input-states-10" name="student_courses" placeholder="Enter..."></textarea>

                                </div>
                            </div>
                            <div class="form-group has-success">
                                <label for="input-states-8"><i class="far fa-building item-icon item-icon-right"></i> Franchise</label>

                                <div class="form-with-icon">
                                    <select required name="franchises" class="form-control" id="input-states-8">
                                        <option class="text-bold text-info" disabled>Paragon Franchise</option>
                                        <?php while($data = $franchises->fetch_assoc()):?>
                                            <?php if($logged_in_user_data['role_id']==3):?>
                                                <option value="<?=$data['id']?>" <?=($franchise['id']==$data['id'])?"selected":"disabled";?>  ><?=$data['name']?></option>
                                            <?php else:?>
                                                <option value="<?=$data['id']?>" ><?=$data['name']?></option>
                                            <?php endif; ?>
                                        <?php endwhile;?>
                                        <i class="fa fa-check item-icon item-icon-right"></i>
                                    </select>
                                </div>
                            </div>

                            <div class="text-center">
                                <input type="submit" class="btn btn-info" name="student_case" value="Initiate Student Case" />
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-footer">
                    Case Generated By: <b><?=$logged_in_user_data["name"]?></b>
                </div>
            </div>
        </div>
    </div>





</div>