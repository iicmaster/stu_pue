<?php 
require_once("../include/session.php");
require_once("../include/connect.php");

if(isset($_POST['submit']))
{ 
	$sql = 'INSERT INTO machine '.
		   'SET '.
				'id_machine_type	= "'.$_POST['id_machine_type'].'",'.
				'name 				= "'.$_POST['name'].'",' .
				'model 				= "'.$_POST['model'].'",' .
				'description		= "'.$_POST['description'] .'",'.
				'id_machine_size	= "'.$_POST['id_machine_size'].'",'.
				'is_enable			= "'.$_POST['is_enable'].'"';

	$query = mysql_query($sql) or die(mysql_error());
	
	// Report
	$css		= '../css/style.css';
	$url_target	= 'machine.php';
	$title		= 'สถานะการทำงาน';
	$message	= '<li class="green">เพิ่มข้อมูลเสร็จสมบูรณ์</li>';
	
	require_once("../iic_tools/views/iic_report.php");
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>เพิ่มอุปกรณ์</title>
<?php include('inc.css.php'); ?>
<!-- jQuery -->
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>

<!-- jQuery - Form validate -->
<link rel="stylesheet" type="text/css" href="../iic_tools/css/jquery.validate.css" />
<script type="text/javascript" src="../iic_tools/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="../iic_tools/js/jquery.validate.additional-methods.js"></script>
<script type="text/javascript" src="../iic_tools/js/jquery.validate.messages_th.js"></script>
<script type="text/javascript" src="../iic_tools/js/jquery.validate.config.js"></script>

<script type="text/javascript">
$(function(){
	$("#menu a#machine").addClass('active');
	
	// Validate form
	$("form").validate();
});
</script>
</head>
<body>
<div id="container">
	<?php include('inc.header.php'); ?>
	<div id="content">
		<h1>เพิ่มอุปกรณ์</h1>
		<hr />
		<form method="post" action="">
			<label for="id_machine_type">ประเภทอุปกรณ์ <span class="red">*</span></label>
			<select id="id_machine_type" name="id_machine_type" class="required">
				<option value="1">เครื่องซักผ้า</option>
				<option value="2">เครื่องอบผ้า</option>
				<option value="3">เตารีด</option>
			</select>
			<label for="id_machine_size">ขนาด <span class="red">*</span></label>
			<select id="id_machine_size" name="id_machine_size" class="required">
				<option value="1">เล็ก</option>
				<option value="2">กลาง</option>
				<option value="3">ใหญ่</option>
			</select>
			<label for="name">ชื่อยี่ห้อ <span class="red">*</span></label>
			<input id="name" name="name" type="text" value="" class="required" />
			<label for="model">ชื่อรุ่น <span class="red">*</span></label>
			<input id="model" name="model" type="text" value="" class="required" />
			<label for="description">คำอธิบาย</label>
			<textarea name="description" rows="5" id="description"></textarea>
			<label>
			สถานะ
			<label for="enable" class="normal">
				<input id="enable" name="is_enable" type="radio" value="1" checked="checked" />
				เปิดใช้งาน </label>
			<label for="disable" class="normal">
				<input id="disable" name="is_enable" type="radio" value="0" />
				ไม่ใช้งาน </label>
			</label>
			<label class="center">
				<input name="submit" type="submit" id="submit" value="บันทึก" />
			</label>
			<hr />
			<a href="machine.php">กลับ</a>
		</form>
	</div>
	<?php include("inc.footer.php"); ?>
</div>
</body>
</html>