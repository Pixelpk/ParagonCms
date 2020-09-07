<?php
    $db_handle = new DBController();
    $conn = $db_handle->connection();
    $query = 'SELECT * FROM `student_case` WHERE `id`='.$_GET['student'];
    $studentCases = $conn->query($query);
    if (@$_GET['documents']=="university"):
    $query = 'SELECT * FROM `university_documents` WHERE `id`='.$_GET['document'];
    elseif(@$_GET['documents']=="student"):
        $query = 'SELECT * FROM `student_documents` WHERE `id`='.$_GET['document'];
    else:
        echo "<script>window.location='404';</script>";
    endif;
    $document = $conn->query($query);
    if ($document->num_rows==0 || !isset($_GET['student']) || ($studentCases->num_rows==0) && ($_GET['documents']!='student' || $_GET['documents']!='university') ):
        echo "<script>window.location='404';</script>";
    endif;
    $query = 'SELECT `id`,`name` FROM `document_types`';
    $documentTypes = $conn->query($query);

    $data = $studentCases->fetch_assoc();
    $document = $document->fetch_assoc();
if (isset($_POST['document_submit'])):
    $document_name = $_POST['document_name'];
    $document_type = $_POST['document_type'];
    $document_genre = $_REQUEST['documents'];
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
        $document_file_name = $_POST['old_file'];
    }
    if ($document_genre=="student"):
        $query = "UPDATE `student_documents` SET `name` = ?,`document_type` = ?,`file` = ?,`notes` = ? WHERE `id` = ?";
    elseif($document_genre=="university"):
        $query = "UPDATE `university_documents` SET `name` = ?,`document_type` = ?,`file` = ?,`notes` = ? WHERE `id` = ?";
    else:
        echo "<script>window.location='404';</script>";
    endif;
    $results = $db_handle->update($query, 'sissi', array($document_name,$document_type,$document_file_name,$document_notes,$document['id'] ));
    //var_dump($results);
    if ($results):
        $message['message'] = ["Document Data Updated Successfully Against Student:".$data['name'],"success"];
    else:
        $message['message'] = ["Error in Inserting Data","danger"];
    endif;
endif;
?>
<style>
    .custom-file-input::-webkit-file-upload-button {
        display: none;
    }
    .custom-file-input::before {
        content: 'Upload Document';
        display: inline-block;
        background: linear-gradient(top, #f9f9f9, #e3e3e3);
        border: 1px solid #009d9e;
        border-radius: 3px;
        padding: 5px 10px;
        outline: none;
        white-space: nowrap;
        -webkit-user-select: none;
        cursor: pointer;
        text-shadow: 1px 1px #fff;
        font-weight: 700;
        font-size: 10pt;
    }
    .custom-file-input:hover::before {
        border-color: rgba(0, 0, 0, 0);
    }
    .custom-file-input:active::before {
        background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
    }
</style>
<div class="row small-spacing">
    <div class="col-lg-12">
        <div class="text-left" style="float:left;">
            <a href="javascript:history.back()" class="btn btn-warning btn-sm"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="text-right">
            <a class="btn btn-info" href="<?=$config['URL']?>/index?nav=view-student-case&student=<?=$data['id']?>">View Student Case</a>
        </div>
        <div class="box-content card white">
            <h3 class="box-title text-center"><?=ucfirst($_GET['documents']);?> Document</h3>
            <h4 class="text-center">Document Submission | <?=$data['name']?></h4>
            <!-- /.box-title -->

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
                                <label for="input-states-4">Name of Document</label>
                                <div class="form-with-icon">
                                    <input required type="text" class="form-control" id="input-states-4" name="document_name" value="<?=$document['name']?>">
                                    <?php ?><i class="fas fa-file item-icon item-icon-right"></i>
                                </div>
                            </div>
                            <div class="form-group has-success">
                                <label for="input-states-1">Type of Document</label>
                                <i class="fas fa-file-archive item-icon item-icon-right"></i>
                                <div class="form-with-icon">
                                    <select required name="document_type" class="form-control" id="input-states-1">
                                        <option class="text-bold text-info" disabled>Document Types</option>
                                        <?php while($datas = $documentTypes->fetch_assoc()):?>
                                            <option value="<?=$datas['id']?>" <?=($datas['id']==$document['document_type'])?"selected":"";?>   ><?=$datas['name']?></option>
                                        <?php endwhile;?>
                                        <i class="fa fa-check item-icon item-icon-right"></i>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group has-inverse">
                                <label for="input-states-7">Upload Document</label>
                                <div class="form-with-icon">
                                    <input type="hidden" name="old_file" value="<?=$document['file'];?>">
                                    <input type="file" class="custom-file-input" id="input-states-7" name="document_file">
                                    <i class="fas fa-file-archive item-icon item-icon-right"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group has-inverse">
                                <label for="input-states-10">Additional Notes</label>
                                <div class="form-with-icon">
                                    <textarea  class="form-control" id="input-states-10" name="document_notes" placeholder="<?=$document['notes'];?>"><?=$document['notes'];?></textarea>
                                    <?php ?><i class="fas fa-sticky-note item-icon item-icon-right"></i>
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
