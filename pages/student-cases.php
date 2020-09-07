<?php
$db_handle = new DBController();
$conn = $db_handle->connection();

$query = 'SELECT `id`,`name` FROM `countries`';
$country = $conn->query($query);

$query = 'SELECT `id`,`name` FROM `universities`';
$university = $conn->query($query);
if ($logged_in_user_data["role_id"]==1){
    $query = 'SELECT * FROM `student_case`';
}elseif($logged_in_user_data["role_id"]==4){
    $query = 'SELECT * FROM `student_case` WHERE `franchise`='.$logged_in_user_data['city_id'];
}else{
    $query = 'SELECT * FROM `student_case` WHERE `case_generated_by`='.$logged_in_user_data['id'];
}

$studentCases = $conn->query($query);
?>
<div class="row">
    <div class="col-md-12">
        <div class="text-left" style="float:left;">
            <a href="javascript:history.back()" class="btn btn-info btn-sm"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="text-right">
            <a class="btn btn-info" href="<?=$config['URL']?>/index?nav=add-student-case">Add New Case</a>
        </div>
        <div class="clearfix"><br></div>
    </div>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Student Cases</h6>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table" style="width:100%">
                        <thead>
                        <tr>
                            <th>Status</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Qualification</th>
                            <th>CNIC</th>
                            <th>Case Generated</th>
                            <th>Franchise</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while($data = $studentCases->fetch_assoc()):
                            $query = 'SELECT `id`,`name` FROM `users` WHERE `id`='.$data['case_generated_by'];
                            $caseGenerated = $conn->query($query);
                            $caseGenerated= $caseGenerated->fetch_assoc();
                            $query = 'SELECT `id`,`name` FROM `franchise` WHERE `id`='.$data['franchise'];
                            $franchise = $conn->query($query);
                            $franchise= $franchise->fetch_assoc();
                            ?>
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <a href="javascript:void" id="<?=$data['id'];?>" onclick="caseDone(this.id);" class="btn <?=($data['case_status']==1)?'btn-success':'btn-outline-success';?> btn-sm" data-toggle="tooltip" title="<?=($data['case_status']==1)?'Case Completed':'Not Completed';?>"><i class="fa fa-check"></i></a>
<!--                                        <a href="javascript:void" id="--><?//=$data['id'];?><!--" onclick="caseNotDone(this.id);" class="btn --><?//=($data['case_status']==1)?'btn-danger':'btn-outline-danger';?><!-- btn-sm" data-toggle="tooltip" title="--><?//=($data['case_status']==1)?'Case Completed':'Not Completed';?><!--"><i class="fa fa-times"></i></a>-->
                                    </div>

                                </td>
                                <td><p><?=$data['name']?></p></td>
                                <td><p><?=$data['email']?></p></td>
                                <td><p><?=$data['phone']?></p></td>
                                <td><p><?=$data['qualification']?></p></td>
                                <td><p><?=$data['cnic']?></p></td>
                                <td><p><?=$caseGenerated['name']?></p></td>
                                <td><p><?=$franchise['name']?></p></td>
                                <td>
                                    <div class="btn-group">

                                        <a href="<?=$config['URL']?>/index?nav=view-student-case&student=<?=$data['id']?>" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="View Case:  <?=$data['name'];?>"><i class="fas fa-eye"></i></a>
                                        <?php if ($logged_in_user_data["role_id"]!=4): ?>
                                            <a href="<?=$config['URL']?>/index?nav=edit-student-case&student=<?=$data['id']?>" class="btn btn-outline-success btn-sm" data-toggle="tooltip" title="Edit Student Case"><i class="fas fa-edit "></i></a>
                                        <?php endif; ?>
                                        <a href="<?=$config['URL']?>/index?nav=document-submission&document=university&student=<?=$data['id']?>" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" title="Add University Document"><i class="fas fa-envelope-open-text"></i></a>
                                        <a href="<?=$config['URL']?>/index?nav=document-submission&document=student&student=<?=$data['id']?>" class="btn btn-outline-dark btn-sm" data-toggle="tooltip" title="Add Student Document"><i class="fas fa-graduation-cap"></i></a>
                                        <a href="<?=$config['URL']?>/index?nav=add-invoice&student=<?=$data['id']?>" class="btn btn-outline-info btn-sm" data-toggle="tooltip" title="Add Student Invoice"><i class="fas fa-file-invoice-dollar"></i></a>
                                    </div>
                                    <!--                            <div class="btn-group">-->
                                    <!--                                <ul class="">-->
                                    <!--                                    <li><a href="--><?//=$config['URL']?><!--/index?nav=view-student-case&student=--><?//=$data['id']?><!--" class="dropdown-item"><i>View Case</i></a></li>-->
                                    <!--                                    <li><a href="--><?//=$config['URL']?><!--/index?nav=document-submission&student=--><?//=$data['id']?><!--" class="dropdown-item">Document Submit</a></li>-->
                                    <!--                                    <li><a href="--><?//=$config['URL']?><!--/index?nav=view-student-case&student=--><?//=$data['id']?><!--" class="dropdown-item">Offer Letter</a></li>-->
                                    <!--                                    <li><a href="--><?//=$config['URL']?><!--/index?nav=view-student-case&student=--><?//=$data['id']?><!--" class="dropdown-item">Visa Request</a></li>-->
                                    <!--                                    <li><a href="--><?//=$config['URL']?><!--/index?nav=view-student-case&student=--><?//=$data['id']?><!--" class="dropdown-item">Invoice</a></li>-->
                                    <!--                                </ul>-->
                                    <!--                            </div>-->
                                </td>
                            </tr>
                        <?php endwhile; ?>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>