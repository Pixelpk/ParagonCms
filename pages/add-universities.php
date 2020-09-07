<?php
if ($logged_in_user_data["role_id"]!=1){
    echo "<script>window.location='404';</script>";
}
    $db_handle = new DBController();
    $conn = $db_handle->connection();
    $query = 'SELECT `id`,`name` FROM `countries`';
    $result = $conn->query($query);
    if (isset($_POST['university'])):
        $universityname = $_POST['university_name'];
        $countries = $_POST['countries'];
        $query = "INSERT INTO `universities` (`name`, `country_id`) values (?, ?)";
        $results = $db_handle->insert($query, 'si', array($universityname,$countries ));
        //var_dump($results);
        if ($results):
            $message = ["University Added Successfully","success"];
        else:
            $message = ["Error in Inserting Data","danger"];
        endif;
    endif;
?>
<div class="row">
    <div class="col-md-12">
        <div class="text-left" style="float:left;">
            <a href="javascript:history.back()" class="btn btn-info btn-sm"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="text-right">
            <a href="<?=$config['URL']?>/index?nav=universities" class="btn btn-info">View All Universities</a>
        </div>
        <div class="clearfix"><br></div>
    </div>

    <div class="col-md-6 offset-md-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Universities</h1>
                <?php if (isset($message)): ?>
                    <div class="alert alert-<?=$message['1']?>">
                        <p><?=$message[0];?></p>
                    </div>
                <?php endif;?>
                <form method="POST">
                    <div class="form-group has-inverse">
                        <label for="input-states-4"><i class="fa fa-university item-icon item-icon-right"></i> Name Of University</label>
                        <div class="form-with-icon">
                            <input type="text" class="form-control" id="input-states-4" name="university_name" placeholder="Enter...">
                        </div>
                    </div>
                    <div class="form-group has-success">
                        <label for="input-states-1"><i class="fas fa-globe item-icon item-icon-right"></i> Country</label>
                        <div class="form-with-icon">
                            <select name="countries" class="form-control" id="input-states-1">
                                <option>Select Country</option>
                                <?php while($data = $result->fetch_assoc()):?>
                                    <option value="<?=$data['id']?>"><?=$data['name']?></option>
                                <?php endwhile;?>

                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn btn-info btn-sm waves-effect waves-light" name="university" value="Add Universities" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>