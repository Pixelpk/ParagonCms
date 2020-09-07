<div class="row">
    <?php
    $notification = $conn->query('SELECT notifications.id as nid,`reference_id`,`unread`,`type`,notifications.created_at as time,users.name as sender FROM `notifications` LEFT JOIN `users` ON notifications.sender_id = users.id WHERE  `recipient_id`='.$logged_in_user_data['id']);
    $notifications = ($notification->num_rows==0)?"No Notifications":NULL;
    ?>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Notifications</h1>
                <?php if ($notifications==NULL): ?>
                    <?php while($n = $notification->fetch_assoc()): ?>
                    <div class="alert <?=($n['unread']==1)?"alert-danger":"alert-success";?> alert-dismissible fade show row" role="alert">
                        <div class="col-11 pt-3">
                            <h4>
                                <strong><?=$n['sender'];?></strong>
                            </h4>
                            <p><?=$n['type'];?></p>
                            <p class="small"><b><?=$n['time'];?></b></p>

                        </div>
                        <div class="col-1 my-auto">
                            <div class="btn-group text-right">
                                <a class="btn <?=($n['unread']==1)?"btn-outline-danger":"btn-outline-success";?>" data-toggle="tooltip" title="View Student Case" id="s<?=$n['nid'];?>" href="index?nav=view-student-case&student=<?=$n['reference_id'];?> "><i class="fa fa-eye"></i></a>
                                <a class="btn <?=($n['unread']==1)?"btn-outline-info":"btn-outline-dark";?> read-notification" href="javascript:;" onclick="getNotification(this.id);" id="<?=$n['nid'];?>" data-toggle="tooltip" title="Mark as Read" ><i class="far fa-check-circle"></i></a>
                            </div>

                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endwhile ;?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>