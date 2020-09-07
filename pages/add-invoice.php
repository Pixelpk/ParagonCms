<?php
    $db_handle = new DBController();
    $conn = $db_handle->connection();
    $query = 'SELECT * FROM `student_case` WHERE `id`='.$_GET['student'];
    $studentCases = $conn->query($query);
    //var_dump($studentCase);
    if (empty($_GET['student']) || ($studentCases->num_rows==0)):
    echo "<script>window.location='404';</script>";
    endif;
    $query = 'SELECT `id`,`name` FROM `document_types`';
    $documentTypes = $conn->query($query);

    $query = 'SELECT `id`,`name` FROM `countries`';
    $country = $conn->query($query);

    $query = 'SELECT `id`,`name` FROM `universities`';
    $university = $conn->query($query);

    $data = $studentCases->fetch_assoc();
    $query = $conn->query("SELECT `name` FROM `users` WHERE `id`=".$data['case_generated_by']);
    $caseGeneratedBy = ($query->num_rows>0)?$query->fetch_assoc():"Unknown";

    if (isset($_POST['add_fees'])):
        $fees = $_POST['fees'];
        $feeAmount = $_POST['fee_amount'];
        $feeType = $_POST['fee_type'];
        $notes = $_POST['notes'];
        $query = "INSERT INTO `fee` (`case_id`,`fees`,`fee_amount`,`fee_type`,`notes`) values (?,?,?,?,?)";
        $results = $db_handle->insert($query, 'isiss', array($data['id'],$fees,$feeAmount,$feeType,$notes ));
        //var_dump($results);
        if ($results):
            $message = ["Fee Added for Student {$data['name']} Successfully","success"];
        else:
            $message = ["Error in Inserting Data","danger"];
        endif;
    endif;

?>

<div class="row">
    <div class="text-left" style="float:left;">
        <a href="javascript:history.back()" class="btn btn-info btn-sm"><i class="fas fa-arrow-circle-left"></i></a>
    </div>
    <div class="col-sm-12 text-right">
        <a href="<?=$config['URL']?>/index?nav=view-student-case&student=<?=$data['id'];?>" class="btn btn-info">View Student's Case</a>
    </div>
    <div class="clearfix"><br></div>
    <div class="col-md-6 offset-md-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add Fees</h4>
                <!-- /.box-title -->
                    <?php if (isset($message)): ?>
                        <div class="alert alert-<?=$message['1']?>">
                            <p><?=$message[0];?></p>
                        </div>
                    <?php endif;?>
                    <form method="POST">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group has-inverse">
                                    <label for="input-states-4"><i class="fas fa-user item-icon item-icon-right"></i> Name Of Student</label>
                                    <div class="form-with-icon">
                                        <input type="text" disabled class="form-control" id="input-states-4" value="<?=$data['name']?>">

                                    </div>
                                </div>
                                <div class="form-group has-success">
                                    <label for="input-states-0"> <i class="fa fa-university item-icon item-icon-right"></i> Fees</label>

                                    <div class="form-with-icon">
                                        <select required name="fees" class="form-control" id="input-states-0">
                                            <option value="Consultancy">Consultancy Fees</option>
                                            <option value="University">University Fees</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group has-inverse">
                                    <label for="input-states-7"><i class="fas fa-money item-icon item-icon-right"></i> Fee Amount</label>
                                    <div class="form-with-icon">
                                        <input required type="text" pattern="[0-9]+" class="form-control" id="input-states-7" name="fee_amount" placeholder="Enter...">

                                    </div>
                                </div>
    <!--                        </div>-->
    <!--                        <div class="col-lg-6">-->
                                <div class="form-group has-success">
                                    <label for="input-states-1"><i class="fa fa-university item-icon item-icon-right"></i> Fee Type</label>

                                    <div class="form-with-icon">
                                        <select required name="fee_type" class="form-control" id="input-states-1">
                                            <option value="Standard">Standard Fees</option>
                                            <option value="Installment">Installment Fees</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group has-inverse">
                                    <label for="input-states-3"><i class="fas fa-paperclip item-icon item-icon-right"></i> Additional Notes</label>
                                    <div class="form-with-icon">
                                        <textarea class="form-control" name="notes" id="" cols="30" rows="10" placeholder="Notes about Fees"></textarea>

                                    </div>
                                </div>
                                <div class="text-center">
                                    <input type="submit" class="btn btn-info btn-sm waves-effect waves-light" name="add_fees" value="Add Fees" />
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="card-footer">
                        <span>Case Generated By: <b><?=$caseGeneratedBy["name"]?></b></span>
                    </div>
            </div>
            <!-- /.card-content -->
        </div>
        <!-- /.box-content card white -->
    </div>
</div>
