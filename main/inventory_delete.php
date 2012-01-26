<?php

require_once('../include/connect.php');

$sql = 'DELETE FROM inventory WHERE id = "'.$_GET['id'].'"';
$query = mysql_query($sql) or die(mysql_error());

// Report
$url_target = 'inventory.php';
$title = 'สถานะการทำงาน';

if($query)
{
	$message = '<li class="green">ลบข้อมูลเสร็จสมบูรณ์</li>';
}
else
{
	$message = '<li class="red">เกิดข้อผิดพลาด: ลบข้อมูลล้มเหลว</li>';
}

require_once("../iic_tools/views/iic_report.php");
exit();

?>