<?php
if ($logged_in_user_data["role_id"]!=1){
    echo "<script>window.location='404';</script>";
}
$db_handle = new DBController();
$conn = $db_handle->connection();
//$query = "SELECT * FROM `universities`";
$query = 'SELECT * FROM `countries`';
$result = $conn->query($query);
?>
<div class="row">

    <div class="col-sm-12">
        <div class="text-left" style="float:left;">
            <a href="javascript:history.back()" class="btn btn-info btn-sm"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="text-right">
            <a class="btn btn-info " href="<?=$config['URL']?>/index?nav=add-countries">Add Countries</a>
        </div>
        <div class="clearfix"><br></div>
    </div>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Countries</h4>
                <table id="dataTableExample" class="table " style="width:100%">
                    <thead>
                    <th>Id</th>
                    <th>Country</th>
                    <th>Created</th>
                    </thead>
                    <tfoot>
                    <th>Id</th>
                    <th>Country</th>
                    <th>Created</th>
                    </tfoot>
                    <tbody>
                    <?php while($data = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?=$data['id']; ?></td>
                        <td><?=$data['name']; ?></td>
                        <td><?=$data['created_at']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>