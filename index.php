<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/autoload.php';
$mail = new PHPMailer();
require_once "Configuration/config.php";
require_once "Configuration/authCookieSessionValidate.php";
if(!$isLoggedIn) {
    header("Location: login");
}
$db_handle = new DBController();
$conn = $db_handle->connection();
$query = 'SELECT * FROM `users` WHERE `id`='.$_SESSION['member_id'];
$result = $conn->query($query);
$logged_in_user_data = $result->fetch_assoc();

$query = 'SELECT `id`,`name` FROM `franchise` WHERE `id`='.$logged_in_user_data['city_id'];
$franchise = $conn->query($query);
$franchise = $franchise->fetch_assoc();
//print_r($data);
$notification = $conn->query('SELECT `unread`,`type`,notifications.created_at as time,users.name as sender FROM `notifications` LEFT JOIN `users` ON notifications.sender_id = users.id WHERE  `recipient_id`='.$logged_in_user_data['id']);
$notifications = ($notification->num_rows==0)?"No Notifications":NULL;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "partials/head.php"; ?>
</head>
<body class="sidebar-dark">
	<div class="main-wrapper">
		<!-- partial:partials/_sidebar.html -->
        <?php require_once "partials/navigation.php"; ?>
        <!-- partial -->
		<div class="page-wrapper">
			<!-- partial:partials/_navbar.html -->
            <?php require_once "partials/top-navigation.php"; ?>
			<!-- partial -->
			<div class="page-content">
                <?php require_once $page; ?>
            </div>
			<!-- partial:partials/_footer.html -->
			<footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between">
				<p class="text-muted text-center text-md-left">Copyright © 2020 <a href="https://pixelpk.com" target="_blank">PixelPK Digital Marketing</a>. All rights reserved</p>
			</footer>
			<!-- partial -->
		</div>
	</div>
	<!-- core:js -->
	<script src="assets/vendors/core/core.js"></script>
	<!-- endinject -->
    <!-- plugin js for this page -->
    <script src="assets/vendors/chartjs/Chart.min.js"></script>
    <script src="assets/vendors/jquery.flot/jquery.flot.js"></script>
    <script src="assets/vendors/jquery.flot/jquery.flot.resize.js"></script>
    <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="assets/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
    <!-- end plugin js for this page -->

    <!-- plugin js for this page -->
    <script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <!-- end plugin js for this page -->

    <!-- inject:js -->
    <script src="assets/vendors/feather-icons/feather.min.js"></script>
    <script src="assets/js/template.js"></script>
    <!-- endinject -->

    <script src="assets/js/data-table.js"></script>
    <!-- custom js for this page -->
    <script src="assets/js/sweet-alert.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/datepicker.js"></script>
    <script src="assets/vendors/sweetalert2/sweetalert2.min.js"></script>
    <script src="assets/vendors/promise-polyfill/polyfill.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
    <!-- end custom js for this page -->
    <script>
        function getNotification(id){
            $.ajax({
                url: "getNotifications.php",
                method: "POST",
                data: { id:id },
                success: function(){
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Notification Read',
                        showConfirmButton: true,
                        timer: 1500
                    }).then(function(){
                        $("#"+id).closest(".alert").addClass("alert-success").removeClass("alert-danger");
                        $("#"+id).addClass("btn-outline-success").removeClass("btn-outline-info");
                        $("#s"+id).addClass("btn-outline-dark").removeClass("btn-outline-info");
                    })
                }
            });
        }
        function caseDone(id){
            $.ajax({
                url: "getCaseDone.php",
                method: "POST",
                data: { id:id },
                success: function(){
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Case Mark Completed',
                        showConfirmButton: true,
                        timer: 1500
                    }).then(function(){
                        $("#"+id).addClass("btn-success").removeClass("btn-outline-success");
                    })
                }
            });
        }
        function caseNotDone(id){
            $.ajax({
                url: "getCaseNotDone.php",
                method: "POST",
                data: { id:id },
                success: function(){
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Case Mark UnCompleted',
                        showConfirmButton: true,
                        timer: 1500
                    }).then(function(){
                        $("#"+id).addClass("btn-danger").removeClass("btn-outline-danger");
                    })
                }
            });
        }
        $(document).ready(function(){
            $("#logout__").on("click",function(){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger mr-2'
                    },
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You will be Logged Out!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'mr-2',
                    confirmButtonText: 'Yes, Log me Out!',
                    cancelButtonText: 'No, I am staying!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        swalWithBootstrapButtons.fire(
                            'Logged Out',
                            'Logged Out Successfully.',
                            'success'
                        )
                            document.location="logout";
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'Your Session continues :)',
                            'error'
                        )
                    }
                })
            });
        });

    </script>
</body>
</html>