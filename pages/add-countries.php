<?php
    if ($logged_in_user_data["role_id"]!=1){
        echo "<script>window.location='404';</script>";
    }
    $db_handle = new DBController();
    $conn = $db_handle->connection();
    $query = 'SELECT `id`,`name` FROM `countries`';
    $result = $conn->query($query);
    if (isset($_POST['country'])):
        $country = $_POST['country_name'];
        $query = "INSERT INTO `countries` (`name`) values (?)";
        $results = $db_handle->insert($query, 's', array($country ));
        //var_dump($results);
        if ($results):
            $message = ["Country Added Successfully","success"];
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
        <div class="col-sm-12 text-right">
            <a href="<?=$config['URL']?>/index?nav=countries" class="btn btn-info">View All Countries</a>
        </div>
    </div>

    <div class="col-md-6 offset-md-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Universities</h4>
                <?php if (isset($message)): ?>
                    <div class="alert alert-<?=$message['1']?>">
                        <p><?=$message[0];?></p>
                    </div>
                <?php endif;?>
                <form method="POST">
                    <div class="form-group has-inverse">
                        <label for="input-states-4"><?php ?><i class="fa fa-globe item-icon item-icon-right"></i> Name Of Country</label>
                        <div class="form-with-icon">
                            <input type="text" class="form-control" id="input-states-4" name="country_name" placeholder="Enter...">

                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn btn-info btn-sm waves-effect waves-light" name="country" value="Add Country" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>