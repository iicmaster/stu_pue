<?php
require_once('../include/connect.php');

$sql = 'DELETE FROM machine WHERE id = "'.$_GET['id'].'"';
$query = mysql_query($sql);

// Report
$css		= '../css/style.css';
$url_target = 'machine.php';
$title 		= 'สถานะการทำงาน';

if($query)
{
	$message = '<li class="green">ลบข้อมูลเสร็จสมบูรณ์</li>';
}
else if(mysql_errno() == 1415)
{
	$message = '<li class="red">เกิดข้อผิดพลาด: เครื่องกำลังถูกใช้งานอยู่ ไม่สามารถลบได้</li>';
	$message .= '<li class="red">การลบข้อมูลถูกยกเลิก</li>';
}
else
{
	die(mysql_error());	
}

require_once("../iic_tools/views/iic_report.php");
exit();
?>