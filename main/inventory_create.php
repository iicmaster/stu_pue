<?php 
require_once("../include/session.php");
require_once("../include/connect.php");

if(isset($_POST['submit']))
{ 
	$sql = 'INSERT INTO inventory 
			SET		
				name 				= "'.$_POST['name'].'",
				id_inventory_unit	= "'.$_POST['id_inventory_unit'].'",
				volume				= "'.$_POST['volume'].'",
				brand		 		= "'.$_POST['brand'].'",
				price		 		= "'.$_POST['price'].'"';

	$query = mysql_query($sql) or die(mysql_error());
	
	// Report
	$css		= '../css/style.css';
	$url_target = 'inventory.php';
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
<title>เพิ่มวัตถุดิบ</title>
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
	$("#menu a#material").addClass('active');
	
	// Validate form
	$("form").validate();
});
</script>
</head>
<body>
<div id="container">
	<?php include('inc.header.php'); ?>
	<div id="content">
		<h1>เพิ่มวัตถุดิบ</h1>
		<hr />
		<form method="post" action="">
			<label for="name">วัตถุดิบ <span class="red">*</span></label>
			<input id="name" name="name" type="text" value="" class="required" />
			<label for="brand">ยี่ห้อ <span class="red">*</span></label>
			<input name="brand" type="text" id="brand" value="" class="required" />
			<label for="volume">ขนาด <span class="red">*</span></label>
			<input type="text" name="volume" id="volume" value="" class="required" />
            <label for="price">ราคาต่อ1หน่วย <span class="red">*</span></label>
			<input type="text" name="price" id="price" value="" class="required" />
			<label for="id_inventory_unit">หน่วย <span class="red">*</span></label>
			<select id="id_inventory_unit" name="id_inventory_unit" class="required">
				<?php 		
				$sql = 'SELECT * FROM inventory_unit';
				$query = mysql_query($sql) or die(mysql_error());
				
				while($data = mysql_fetch_array($query))
				{
					echo '<option value="'.$data['id'].'" >'.$data['name'].'</option>';
				}  
				
				?>
			</select>
			<label class="center">
				<input name="submit" type="submit" id="submit" value="บันทึก" />
			</label>
			<hr />
			<a href="inventory.php">กลับ</a>
		</form>
	</div>
	<?php include("inc.footer.php"); ?>
</div>
</body>
</html>