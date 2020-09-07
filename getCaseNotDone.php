<?php
require_once "Configuration/config.php";
require_once "Configuration/authCookieSessionValidate.php";
$id = $_POST['id'];
$db_handle = new DBController();
$conn = $db_handle->connection();
$conn->query('UPDATE `student_case` SET `case_status`=0 WHERE `id`='.$id);
?>
