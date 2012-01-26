<?php 
require_once("../include/session.php");
require_once("../include/connect.php");

if(isset($_POST['submit']))
{ 
	$sql = 'UPDATE inventory 
	
			SET		
				name 				= "'.$_POST['name'].'",
				id_inventory_unit	= "'.$_POST['id_inventory_unit'].'",
				volume				= "'.$_POST['volume'].'",
				brand				= "'.$_POST['brand'].'"
			
			WHERE id = "'.$_POST['id'].'"';

	$query = mysql_query($sql) or die(mysql_error());
	
	// Report
	$url_target = 'inventory.php';
	$title = 'สถานะการทำงาน';
	
	if($query)
	{
		$message = '<li class="green">บันทึกมูลเสร็จสมบูรณ์</li>';
	}
	else
	{
		$message = '<li class="red">เกิดข้อผิดพลาด: บันทึกข้อมูลล้มเหลว</li>';
	}
	
	require_once("../iic_tools/views/iic_report.php");
	exit();
}

$sql = 'SELECT 
			inventory.*,
			inventory_unit.name as "unit"
			
		FROM inventory
		
		LEFT JOIN inventory_unit
		ON inventory.id_inventory_unit = inventory_unit.id
		
 		WHERE inventory.id = "'.$_GET['id'].'"';
		
$query = mysql_query($sql) or die(mysql_error());
$data = mysql_fetch_array($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>แก้ไขข้อมูลวัตถุดิบ</title>
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
		<h1>แก้ไขข้อมูลวัตถุดิบ</h1>
		<hr />
		<form method="post" action="">
			<label for="name">วัตถุดิบ <span class="red">*</span></label>
			<input id="name" name="name" type="text" value="<?php echo $data['name']; ?>" class="required" />
			<label for="brand">ยี่ห้อ <span class="red">*</span></label>
			<input name="brand" type="text" id="brand" value="<?php echo $data['brand']; ?>" class="required" />
			<label for="volume">ขนาด <span class="red">*</span></label>
			<input type="text" name="volume" id="volume" value="<?php echo $data['volume']; ?>" class="required" />
			<label for="id_inventory_unit">หน่วย <span class="red">*</span></label>
			<select id="id_inventory_unit" name="id_inventory_unit" class="required" >
				<?php 		
				$sql = 'SELECT * FROM inventory_unit';
				$query = mysql_query($sql) or die(mysql_error());
				
				while($data_unit = mysql_fetch_array($query))
				{
					$selected = ($data['id_inventory_unit'] == $data_unit['id']) ? 'selected="selected"' : '';
					
					echo '<option value="'.$data_unit['id'].'" '.$selected.' >'.$data_unit['name'].'</option>';
				}  
				
				?>
			</select>
			<input name="id" type="hidden" value="<?php echo $_GET['id'] ?>" />
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