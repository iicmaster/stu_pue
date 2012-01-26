<?php
require_once('../include/connect.php');

$sql = 'DELETE FROM customer WHERE id = '.$_GET['id'];
$query = mysql_query($sql);

// Report
$css		= '../css/style.css';
$url_target	= 'customer.php';
$title		= 'สถานะการทำงาน';
$message	= '';

if($query)
{
	$message = '<li class="green">ลบข้อมูลเสร็จสมบูรณ์</li>';
}
else if(mysql_errno() == 1451)
{
	$message = '<li class="red">ไม่สามารถลบข้อมูลได้ เนื่องจากมีรายชื่ออยู่ใบรายการ</li>';
	$message .= '<li class="red">การลบข้อมูลถูกยกเลิก</li>';
}
else
{
	echo mysql_errno().' : '.mysql_error();	
	exit();
}

require_once("../iic_tools/views/iic_report.php");
exit();
?>