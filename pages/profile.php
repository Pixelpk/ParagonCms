<?php


    if (isset($_POST['update'])):

        $oldPassword = $_POST['oldpassword'];

        if (password_verify($oldPassword,$logged_in_user_data['password'])):
            //echo $logged_in_user_data['password'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            if (!empty($_POST['password'])):
                $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
                //echo "<br>".$password;
            else:
                $password = password_hash($oldPassword,PASSWORD_DEFAULT);
            endif;
            $query = "UPDATE `users` SET `name` = ?,`phone` = ?, `address` = ?,`password` = ?  WHERE `id`= ?";
            $results = $db_handle->update($query, 'ssssi', array($name,$phone,$address,$password,$logged_in_user_data['id']));
            $_SESSION['message'] = ["Successfully Updated the information","success"];
            //echo "<script> window.location='index?nav=profile'; </script>";
        else:
            $_SESSION['message'] = ["Cannot Update Information, Enter Correct Password","warning"];
        endif;
    endif;

?>
<div class="row">
    <div class="col-md-12">
        <div class="text-left" style="float:left;">
            <a href="javascript:history.back()" class="btn btn-info btn-sm"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="clearfix"><br></div>
    </div>
    <div class="col-md-6 offset-md-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Profile</h4>
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?=$_SESSION['message']['1']?>">
                        <p><?=$_SESSION['message'][0];?></p>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif;?>
                <form method="POST">
                    <div class="form-group has-inverse">
                        <label for="input-states-1"><?php ?><i class="fa fa-user item-icon item-icon-right"></i> Name</label>
                        <div class="form-with-icon">
                            <input type="text" class="form-control" id="input-states-1" name="name" placeholder="<?=$logged_in_user_data['name']?>" value="<?=$logged_in_user_data['name']?>">

                        </div>
                    </div>
                    <div class="form-group has-inverse">
                        <label for="input-states-2"><?php ?><i class="fa fa-envelope item-icon item-icon-right"></i> Email</label>
                        <div class="form-with-icon">
                            <input type="email" class="form-control" id="input-states-2" disabled value="<?=$logged_in_user_data['email']?>">

                        </div>
                    </div>
                    <div class="form-group has-inverse">
                        <label for="input-states-3"><?php ?><i class="fas fa-phone item-icon item-icon-right"></i> Phone</label>
                        <div class="form-with-icon">
                            <input type="tel" class="form-control" id="input-states-3" name="phone"  value="<?=$logged_in_user_data['phone']?>" placeholder="<?=$logged_in_user_data['phone']?>">

                        </div>
                    </div>
                    <div class="form-group has-inverse">
                        <label for="input-states-4"><?php ?><i class="fas fa-address-card item-icon item-icon-right"></i> Address</label>
                        <div class="form-with-icon">
                            <input type="text" class="form-control" id="input-states-4" name="address"  value="<?=$logged_in_user_data['address']?>" placeholder="<?=$logged_in_user_data['address']?>">

                        </div>
                    </div>
                    <div class="form-group has-inverse">
                        <label for="input-states-5"><?php ?><i class="fas fa-lock item-icon item-icon-right"></i> Existing Password <sup>*</sup></label>
                        <div class="form-with-icon">
                            <input required="" type="password" class="form-control" id="input-states-5" name="oldpassword" >

                        </div>
                    </div>
                    <div class="form-group has-inverse">
                        <label for="input-states-6"><?php ?><i class="fas fa-key item-icon item-icon-right"></i> New Password</label>
                        <div class="form-with-icon">
                            <input type="password" class="form-control" id="input-states-6" name="password" >

                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn btn-success" name="update" value="Update Profile" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
