<?php
require_once('function.php');
$dbc = new Dbc();
$dbc ->tablename = 'user_info';
$dbc ->datadelete($_POST['btnid']);
$result = $_POST['btnid'];
header('Content-type:application/json; charset=utf8');
echo json_encode($result);
?>
