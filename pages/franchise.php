<?php
if ($logged_in_user_data["role_id"]!=1){
    echo "<script>window.location='404';</script>";
}
$db_handle = new DBController();
$conn = $db_handle->connection();
//$query = "SELECT * FROM `universities`";
$query = 'SELECT * FROM `franchise` ORDER BY `id` DESC';
$result = $conn->query($query);
?>
<div class="row">

    <div class="col-sm-12">
        <div class="text-left" style="float:left;">
            <a href="javascript:history.back()" class="btn btn-info btn-sm"><i class="fas fa-arrow-circle-left"></i></a>
        </div>
        <div class="text-right">
            <a class="btn btn-info" href="<?=$config['URL']?>/index?nav=add-franchise">Add Franchise</a>
        </div>
        <div class="clearfix"><br></div>
    </div>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Franchises</h4>
                <table id="dataTableExample" class="table" style="width:100%">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Franchise</th>
                        <th>Created</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($data = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?=$data['id'];?></td>
                        <td><?=$data['name'];?></td>
                        <td><?=$data['created_at'];?></td>

                    </tr>
                    <?php endwhile; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Franchise</th>
                        <th>Created</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>