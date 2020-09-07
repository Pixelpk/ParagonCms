<?php
    $db_handle = new DBController();
    $conn = $db_handle->connection();
    if ($logged_in_user_data["role_id"]!=1){
        echo "<script>window.location='404';</script>";
    }
    $franchises = "SELECT * FROM `franchise`";
    $franchises = $conn->query($franchises);
    ?>
<div class="row">
    <div class="col-12">
        <h2 class="text-info text-center">Franchise Reports</h2>
        <hr width="50%" class="text-center">
    </div>
    <?php $i=1; while($d=$franchises->fetch_assoc()): ?>
    <?php
        $reportFranchiseAdmissions = 'SELECT count(*) as total_queries FROM `student_case` as c left join franchise on c.franchise = franchise.id WHERE franchise.id='.$d['id'];
        $reportFranchiseAdmissions = $conn->query($reportFranchiseAdmissions);
        $reportFranchiseAdmissions = (@$reportFranchiseAdmissions->num_rows>0)?$reportFranchiseAdmissions->fetch_assoc():0;
    ?>
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <h6 class="card-title text-center"><?=$d['name'];?></h6>
                </div>
                <div class="row">
                    <div class="col-6 offset-3">
                        <h3 class="mb-2"><?=(isset($reportFranchiseAdmissions['total_queries']))?$reportFranchiseAdmissions['total_queries']:0;?></h3>
                        <div class="d-flex align-items-baseline">
                            <p class="text-danger">
                                <span>Ongoing Cases</span>
                                <i data-feather="arrow-down" class="icon-sm mb-1"></i>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a class="btn btn-success btn-sm" href="<?=$config['URL']?>/index?nav=report-franchise&franchise=<?=$d['id'];?>">View Franchise Report</a>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>

</div>
