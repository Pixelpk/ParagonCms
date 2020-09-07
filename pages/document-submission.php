<?php
    $db_handle = new DBController();
    $conn = $db_handle->connection();
    $query = 'SELECT * FROM `student_case` WHERE `id`='.$_GET['student'];
    $studentCases = $conn->query($query);
    //var_dump($studentCase);
    if (empty($_GET['student']) || ($studentCases->num_rows==0) &&($_GET['document']!='student' || $_GET['document']!='university') ):
        echo "<script>window.location='404';</script>";
    endif;
    $query = 'SELECT `id`,`name` FROM `document_types`';
    $documentTypes = $conn->query($query);

    $data = $studentCases->fetch_assoc();

    if (isset($_POST['document_submit'])):
        $document_name = $_POST['document_name'];
        $document_type = $_POST['document_type'];
        $document_genre = $_REQUEST['document'];
        $document_notes = $_POST['document_notes'];
        if (!empty($_FILES['document_file']['tmp_name'])){
            $document_file_name = $_FILES['document_file']['name'];
            $document_file_size = $_FILES['document_file']['size'];
            $document_file_type = $_FILES['document_file']['type'];
            $document_file_temp = $_FILES['document_file']['tmp_name'];
            $newPath = "uploads/".$document_file_name;
            if(!move_uploaded_file($document_file_temp,$newPath)){
                $message["document"] = ["Error in Uploading Document","danger"];
            }
        }else{
            $document_file_name = "404";
            $message["document"] = ["Document Not Uploaded","warning"];
        }
        if ($document_genre=="student"):
            $query = "INSERT INTO `student_documents`(`case_id`,`name`,`document_type`,`file`,`notes`) values (?,?,?,?,?)";
            $notification = "Document has been added for Student -<b>".$data['name']."</b>- and Document Updated is -<b>".$document_name."</b>- Author for this Change: -<b>".$logged_in_user_data['name']."</b>-" ;
            if ($logged_in_user_data["role_id"] != 4):
                createNotification($logged_in_user_data['id'],$notification,$data['id'],$logged_in_user_data['city_id']);
            else:
                createNotification($logged_in_user_data['id'],$notification,$data['id'],$logged_in_user_data['city_id'],$data['case_generated_by']);
            endif;
        elseif($document_genre=="university"):
            $query = "INSERT INTO `university_documents`(`case_id`,`name`,`document_type`,`file`,`notes`) values (?,?,?,?,?)";
            $notification = "Document has been added for Student -<b>".$data['name']."</b>- and Document Updated is -<b>".$document_name."</b>- Author for this Change: -<b>".$logged_in_user_data['name']."</b>-" ;
            if ($logged_in_user_data["role_id"] != 4):
                createNotification($logged_in_user_data['id'],$notification,$data['id'],$logged_in_user_data['city_id']);
            else:
                createNotification($logged_in_user_data['id'],$notification,$data['id'],$logged_in_user_data['city_id'],$data['case_generated_by']);
            endif;
        else:
            echo "<script>window.location='404';</script>";
        endif;
        $results = $db_handle->insert($query, 'isiss', array($data['id'],$document_name,$document_type,$document_file_name,$document_notes ));
        //var_dump($results);
        if ($results):
            $message['message'] = ["Document Added Successfully Against Student:".$data['name'],"success"];
        else:
            $message['message'] = ["Error in Inserting Data","danger"];
        endif;
    endif;
?>
<div class="row small-spacing">
    <div class="col-md-12">
        <div class="text-left" style="float:left;">
            <a href="javascript:history.back()" class="btn btn-info btn-sm"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="text-right">
            <a class="btn btn-info" href="<?=$config['URL']?>/index?nav=view-student-case&student=<?=$data['id']?>">View Student Case</a>
        </div>
        <div class="clearfix"><br></div>
    </div>

    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center"><?=ucfirst($_GET['document']);?> Document</h3>
                <h4 class="card-title text-center">Document Submission | <?=$data['name']?></h4>
                <?php if (isset($message['message'])): ?>

                    <div class="alert alert-<?=$message['message']['1']?>">
                        <p><?=$message['message'][0];?></p>
                    </div>
                    <?php if (isset($message["document"])): ?>
                        <div class="alert alert-<?=$message["document"]['1']?>">
                            <p><?=$message["document"][0];?></p>
                        </div>
                    <?php endif;?>
                <?php endif;?>
                <div class="card-content">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group has-inverse">
                                    <label for="input-states-4"><i class="fas fa-file item-icon item-icon-right"></i> Name of Document</label>
                                    <div class="form-with-icon">
                                        <input required type="text" class="form-control" id="input-states-4" name="document_name" placeholder="Enter...">

                                    </div>
                                </div>
                                <div class="form-group has-success">
                                    <label for="input-states-1"><i class="fas fa-file-archive item-icon item-icon-right"></i> Type of Document</label>

                                    <div class="form-with-icon">
                                        <select required name="document_type" class="form-control" id="input-states-1">
                                            <option class="text-bold text-info" disabled>Document Types</option>
                                            <?php while($datas = $documentTypes->fetch_assoc()):?>
                                                <option value="<?=$datas['id']?>"><?=$datas['name']?></option>
                                            <?php endwhile;?>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group has-inverse">
                                    <label for="input-states-7"><i class="fas fa-file-archive item-icon item-icon-right"></i> Upload Document</label>
                                    <div class="form-with-icon">
                                        <input type="file" class="form-control-file" id="input-states-7" name="document_file">

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group has-inverse">
                                    <label for="input-states-10"><i class="fas fa-sticky-note item-icon item-icon-right"></i> Additional Notes</label>
                                    <div class="form-with-icon">
                                        <textarea  class="form-control" id="input-states-10" name="document_notes" placeholder="Description of Document"></textarea>

                                    </div>
                                </div>
                                <div class="text-center">
                                    <input type="submit" class="btn btn-info btn-sm waves-effect waves-light" name="document_submit" value="Upload Document" />
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
