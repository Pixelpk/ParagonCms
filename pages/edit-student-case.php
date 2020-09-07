<?php
$db_handle = new DBController();
$conn = $db_handle->connection();
$query = 'SELECT `id`,`name`,`email`,`phone`,`qualification`,`cnic`,`case_generated_by`,`franchise`,`universities`,`countries`,`passport`,`courses` FROM `student_case` WHERE `id`='.$_GET['student'];
$studentCase = $conn->query($query);
if (empty($_GET['student']) || empty($studentCase) || $logged_in_user_data["role_id"] == 4):
    echo "<script>window.location='404';</script>";
endif;


$studentCase = $studentCase->fetch_assoc();


$query = 'SELECT `id`,`name` FROM `countries`';
$country = $conn->query($query);

$query = 'SELECT `id`,`name` FROM `franchise`';
$franchises = $conn->query($query);

$query = 'SELECT `id`,`name` FROM `universities`';
$university = $conn->query($query);


if (isset($_POST['update_student_case'])):
    $student_name = $_POST['student_name'];
    $student_email = $_POST['student_email'];
    $student_phone = $_POST['student_phone'];
    $student_qualification = $_POST['student_qualification'];
    $student_cnic = $_POST['student_cnic'];
    $student_passport = $_POST['student_passport'];
    $student_courses = $_POST['student_courses'];
    $countries="";
    $universities="";
    if (isset($_POST['countries'])){
        foreach($_POST['countries'] as $c):
            $countries.= $c.",";
        endforeach;
    }else{
        $countries=$_POST['countries_old'];
    }
    if (isset($_POST['universities'])) {
        foreach ($_POST['universities'] as $c):
            $universities .= $c . ",";
        endforeach;
    }else{
        $universities=$_POST['universities_old'];
    }
    $case_generated = (int)$logged_in_user_data["id"];
    // var_dump($results);
    $query = "UPDATE `student_case` SET `name` = ?,`email` = ?,`phone` = ?,`qualification` = ?,`universities` = ?, `countries` = ? , `cnic` = ?, `passport` = ?, `courses` = ?  WHERE `id`= ?";
    $results = $db_handle->update($query, 'sssssssssi', array($student_name,$student_email,$student_phone,$student_qualification,$universities,$countries,$student_cnic,$student_passport,$student_courses,$studentCase['id']));
    if ($results):
        $message = ["Student Case Updated Successfully","success"];
        echo "<script>window.location='index?nav=view-student-case&student=".$studentCase['id']."'</script>";
    else:
        $message = ["Error in Updating Data","danger"];
    endif;
endif;
?>
<div class="row">
    <div class="col-md-12">
        <div class="text-left" style="float:left;">
            <a href="javascript:history.back()" class="btn btn-info btn-sm"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="text-right">
            <a href="<?=$config['URL']?>/index?nav=view-student-case&student=<?=$studentCase['id']?>" class="btn btn-info ">View <?=$studentCase['name'];?> Case</a>
        </div>
        <div class="clearfix"><br></div>

    </div>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Update a Student Case</h4>
                <?php if (isset($message)): ?>
                    <div class="alert alert-<?=$message['1']?>">
                        <p><?=$message[0];?></p>
                    </div>
                <?php endif;?>
                <form method="POST">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group has-inverse">
                                <label for="input-states-4"><i class="fas fa-user item-icon item-icon-right"></i> Name Of Student </label>
                                <div class="form-with-icon">
                                    <input type="text" class="form-control" id="input-states-4" name="student_name" value="<?=$studentCase['name']?>">

                                </div>
                            </div>
                            <div class="form-group has-inverse">
                                <label for="input-states-3"><i class="fas fa-envelope item-icon item-icon-right"></i> Email Of Student</label>
                                <div class="form-with-icon">
                                    <input type="email" class="form-control" id="input-states-3" name="student_email" value="<?=$studentCase['email']?>">

                                </div>
                            </div>
                            <div class="form-group has-inverse">
                                <label for="input-states-2"><i class="fa fa-phone item-icon item-icon-right"></i> Phone Number Of Student</label>
                                <div class="form-with-icon">
                                    <input type="tel" class="form-control" id="input-states-2" name="student_phone" value="<?=$studentCase['phone']?>">

                                </div>
                            </div>
                            <div class="form-group has-inverse">
                                <label for="input-states-6"><i class="fas fa-graduation-cap item-icon item-icon-right"></i> Qualification Of Student</label>
                                <div class="form-with-icon">
                                    <input type="tel" class="form-control" id="input-states-6" name="student_qualification" value="<?=$studentCase['qualification']?>">

                                </div>
                            </div>
                            <div class="form-group has-inverse">
                                <label for="input-states-7"><i class="fas fa-id-card item-icon item-icon-right"></i> CNIC Of Student</label>
                                <div class="form-with-icon">
                                    <input type="tel" class="form-control" id="input-states-7" name="student_cnic" value="<?=$studentCase['cnic']?>">
                                </div>
                            </div>
                            <div class="form-group has-inverse">
                                <label for="input-states-9"><i class="fas fa-passport item-icon item-icon-right"></i> Passport Of Student</label>
                                <div class="form-with-icon">
                                    <input required type="tel" class="form-control" id="input-states-9" name="student_passport" value="<?=$studentCase['passport']?>">

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <input type="hidden" name="countries_old" value="<?=$studentCase['countries']?>">
                            <input type="hidden" name="universities_old" value="<?=$studentCase['universities']?>">
                            <div class="form-group has-success">
                                <label for="input-states-1"><i class="fa fa-globe item-icon item-icon-right"></i> Country</label>

                                <div class="help-text text-bold text-danger">Leave blank for previous data for Countries</div>
                                <div class="form-with-icon">
                                    <select  name="countries[]" class="form-control" id="input-states-1" multiple>
                                        <option class="text-bold text-info" disabled>Student Prefered Countries</option>
                                        <?php while($data = $country->fetch_assoc()):?>
                                            <option value="<?=$data['id']?>"><?=$data['name']?></option>
                                        <?php endwhile;?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group has-success">
                                <label for="input-states-0"><i class="fa fa-university item-icon item-icon-right"></i> Universities</label>

                                <div class="help-text text-danger text-bold">Leave blank for previous data for Universities</div>
                                <div class="form-with-icon">
                                    <select name="universities[]" class="form-control" id="input-states-0" multiple>
                                        <option class="text-bold text-info" disabled>Student Prefered Universities</option>
                                        <?php while($data = $university->fetch_assoc()):?>
                                            <option value="<?=$data['id']?>"><?=$data['name']?></option>
                                        <?php endwhile;?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group has-inverse">
                                <label for="input-states-10"><i class="fas fa-paragraph item-icon item-icon-right"></i> Interested Courses</label>
                                <div class="form-with-icon">
                                    <textarea required class="form-control" id="input-states-10" name="student_courses" placeholder="<?=$studentCase['courses']?>"><?=$studentCase['courses']?></textarea>

                                </div>
                            </div>
                            <div class="form-group has-success">
                                <label for="input-states-8"><i class="fas fa-building item-icon item-icon-right"></i> Franchise</label>

                                <div class="form-with-icon">
                                    <select name="franchises" class="form-control" id="input-states-8">
                                        <option class="text-bold text-info" disabled>Paragon Franchise</option>
                                        <?php while($data = $franchises->fetch_assoc()):?>
                                            <?php if($logged_in_user_data['role_id']==3):?>
                                                <option value="<?=$data['id']?>" <?=($studentCase['franchise']==$data['id'])?"selected":"disabled";?>  ><?=$data['name']?></option>
                                            <?php else:?>
                                                <option value="<?=$data['id']?>"  <?=($studentCase['franchise']==$data['id'])?"selected":"disabled";?>><?=$data['name']?></option>
                                            <?php endif; ?>
                                        <?php endwhile;?>

                                    </select>
                                </div>
                            </div>
                            <div class="text-center">
                                <input type="submit" class="btn btn-info btn-sm waves-effect waves-light" name="update_student_case" value="Update Student Case" />
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="card-footer">
                <span>Case Generated By: <b><?=$logged_in_user_data["name"]?></b></span>
            </div>
        </div>
    </div>
</div>