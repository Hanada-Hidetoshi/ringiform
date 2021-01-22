<?php
require_once('function2.php');
$dbc = new Dbc();
$dbc ->tablename = 'ringi_info';
$dbc ->datadelete($_POST['btnid']);
$result = $_POST['btnid'];
header('Content-type:application/json; charset=utf8');
echo json_encode($result);
?>
