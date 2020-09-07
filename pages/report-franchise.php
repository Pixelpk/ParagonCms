<?php
if ($logged_in_user_data["role_id"]!=1){
    echo "<script>window.location='404';</script>";
}
    $db_handle = new DBController();
    $conn = $db_handle->connection();
    $query = 'SELECT * FROM `franchise` WHERE `id`='.$_GET['franchise'];
    $franchise = $conn->query($query);
    //var_dump($studentCase);
    if (empty($_GET['franchise'])):
        echo "<script>window.location='404';</script>";
    endif;
    $data = "SELECT a1.id,a1.name,a1.email,a1.phone,a1.cnic,a1.qualification,a1.universities,a1.countries,a1.created_at,a1.updated_at, 
                users.name as case_generator 
                FROM student_case as a1 
                left join franchise on a1.franchise=franchise.id 
                left join users on a1.case_generated_by=users.id 
                WHERE franchise.id=".$_GET['franchise'];
    $data = $conn->query($data);

    $universities = $conn->query("SELECT * FROM `universities`");
    $universities = $universities->fetch_all();
    $countries = $conn->query("SELECT * FROM `countries`");
    $countries = $countries->fetch_all();
?>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
<div class="row">

    <div class="col-md-12">
        <div class="text-left" style="float:left;">
            <a href="javascript:history.back()" class="btn btn-info btn-sm"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="text-right">
            <a class="btn btn-info" href="<?=$config['URL']?>/index?nav=reports">View All Reports</a>
        </div>
        <div class="clearfix"><br></div>
    </div>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Student Cases</h4>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table" style="width:100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Qualification</th>
                            <th>CNIC</th>
                            <th>Case Generated</th>
                            <th>Prefered Universities</th>
                            <th>Prefered Countries</th>
                            <th>University Fee</th>
                            <th>Consultancy Fee</th>
                            <th>Case Initiated</th>
                            <th>Last Modification</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($data->num_rows>0):
                            while($d = $data->fetch_assoc()):
                                $university = explode(',',$d['universities']);
                                $preferedUniversities = [];
                                foreach($universities as $uni):
                                    foreach ($university as $u){
                                        if ($uni[0]==$u){
                                            array_push($preferedUniversities,$uni[1]);
                                        }
                                    }
                                endforeach;
                                $country = explode(',',$d['countries']);
                                $preferedCountries = [];
                                foreach($countries as $con):
                                    foreach ($country as $c){
                                        if ($con[0]==$c){
                                            array_push($preferedCountries,$con[1]);
                                        }
                                    }
                                endforeach;
                                $feeUniversity = $conn->query("SELECT SUM(`fee_amount`) as total FROM `fee` WHERE `fees` = 'University' AND case_id=".$d['id']);
                                $feeUniversity = $feeUniversity->fetch_assoc();
                                $feeConsultancy = $conn->query("SELECT SUM(`fee_amount`) as total FROM `fee` WHERE `fees` = 'Consultancy' AND case_id=".$d['id']);
                                $feeConsultancy = $feeConsultancy->fetch_assoc();

                                ?>
                                <tr>
                                    <td><p><?=$d['id']?></p></td>
                                    <td><p><?=$d['name']?></p></td>
                                    <td><p><?=$d['email']?></p></td>
                                    <td><p><?=$d['phone']?></p></td>
                                    <td><p><?=$d['qualification']?></p></td>
                                    <td><p><?=$d['cnic']?></p></td>
                                    <td><p><?=$d['case_generator']?></p></td>
                                    <td><p><?php foreach($preferedUniversities as $u){echo $u.", ";} ?></p></td>
                                    <td><p><?php foreach($preferedCountries as $u){echo $u.", ";} ?></p></td>
                                    <td><p><?=$feeUniversity['total']?></p></td>
                                    <td><p><?=$feeConsultancy['total']?></p></td>
                                    <td><p><?=$d['created_at']?></p></td>
                                    <td><p><?=$d['updated_at']?></p></td>
                                    <td><p><a href="<?=$config['URL']?>/index?nav=view-student-case&student=<?=$d['id']?>" class="btn btn-info btn-sm" data-toggle="tooltip" title="View Case:  <?=$d['name'];?>"><i class="fas fa-eye"></i></a></p></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                No Record Found
                            </tr>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Qualification</th>
                            <th>CNIC</th>
                            <th>Case Generated</th>
                            <th>Prefered Universities</th>
                            <th>Prefered Countries</th>
                            <th>University Fee</th>
                            <th>Consultancy Fee</th>
                            <th>Case Initiated</th>
                            <th>Last Modification</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
