<?php
    $completed = $conn->query("SELECT * FROM `student_case` WHERE `case_status`=1");
    $completed = $completed->num_rows;
    $unCompleted = $conn->query("SELECT * FROM `student_case` WHERE `case_status`!=1");
    $unCompleted = $unCompleted->num_rows;
    $staff = $conn->query("SELECT * FROM `users` WHERE `role_id`=3");
    $staff = $staff->num_rows;

    $notification = $conn->query('SELECT `unread`,`type`,notifications.created_at as time,users.name as sender FROM `notifications` LEFT JOIN `users` ON notifications.sender_id = users.id WHERE  `recipient_id`='.$logged_in_user_data['id']);
    $notifications = ($notification->num_rows==0)?"No Notifications":NULL;

    if ($logged_in_user_data["role_id"]==1){
        $query = 'SELECT * FROM `student_case`';
    }elseif($logged_in_user_data["role_id"]==4){
        $query = 'SELECT * FROM `student_case` WHERE `franchise`='.$logged_in_user_data['city_id'];
    }else{
        $query = 'SELECT * FROM `student_case` WHERE `case_generated_by`='.$logged_in_user_data['id'];
    }

    $studentCases = $conn->query($query);

?>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <div class="input-group date datepicker dashboard-date mr-2 mb-2 mb-md-0 d-md-none d-xl-flex" id="dashboardDate">
            <span class="input-group-addon bg-transparent"><i data-feather="calendar" class=" text-primary"></i></span>
            <input type="text" class="form-control">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Case Completed</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2"><?=$completed;  ?></h3>
                            </div>
                            <div class="col-6 col-md-12 col-xl-7">
                                <div id="apexChart1" class="mt-md-3 mt-xl-0"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Case Pending</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2"><?=$unCompleted;  ?></h3>
                            </div>
                            <div class="col-6 col-md-12 col-xl-7">
                                <div id="apexChart2" class="mt-md-3 mt-xl-0"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Total Consultants</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2"><?=$staff;?></h3>
                            </div>
                            <div class="col-6 col-md-12 col-xl-7">
                                <div id="apexChart3" class="mt-md-3 mt-xl-0"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- row -->

<div class="row">
    <div class="col-lg-5 col-xl-4 grid-margin grid-margin-xl-0 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Notifications</h6>
                    <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton6">
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <?php if ($notifications==NULL): ?>
                    <?php while($n = $notification->fetch_assoc()): ?>
                    <a href="#" class="d-flex align-items-center border-bottom pb-3">
                        <div class="mr-3">
                          <i class="far fa-user"></i>
                        </div>
                        <div class="w-100">
                            <div class="d-flex justify-content-between">
                                <h6 class="text-body mb-2"><?=$n['sender'];?></h6>
                                <p class="text-muted tx-12"><?=$n['time'];?></p>
                            </div>
                            <p class="text-muted tx-13"><?=$n['type'];?></p>
                        </div>
                    </a>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <a href="javascript:;" class="dropdown-item">
                            <div class="icon">
                                <i data-feather="user-plus"></i>
                            </div>
                            <div class="content">
                                <p>No Notifications</p>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7 col-xl-8 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">New Student Cases</h6>
                    <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton7">
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table" style="width:100%">
                        <thead>
                        <tr>

                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
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
                                <td><p><?=$data['name']?></p></td>
                                <td><p><?=$data['email']?></p></td>
                                <td><p><?=$data['phone']?></p></td>
                                <td><p><?=$caseGenerated['name']?></p></td>
                                <td><p><?=$franchise['name']?></p></td>
                                <td>
                                    <a href="<?=$config['URL']?>/index?nav=view-student-case&student=<?=$data['id']?>" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="View Case:  <?=$data['name'];?>"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div> <!-- row -->