<?php require_once("../include/session.php"); ?>
<?php
require_once("../include/connect.php");

if(isset($_POST['submit']))
{ 
	if($_POST['is_member'] == 1)
	{
		$date_exp	= '"'.date('Y-m-d', strtotime($_POST['date_start'].'+1 month')).'"';
		$date_start = '"'.$_POST['date_start'].'"';
		$credit		= 50;
		
		if($date_exp < $_POST['date_exp'])
		{
			$date_exp = '"'.$_POST['date_exp'].'"';
		}
	}
	else
	{
		$date_exp 	= 'NULL';
		$date_start = 'NULL';
		$credit		= 0;
	}
	
	$sql = 'UPDATE customer 
			SET '.
				'name 				= "'.$_POST['name'].'",'.
				'lastname			= "'.$_POST['lastname'].'",' .
				'nickname			= "'.$_POST['nickname'] .'",'.
				'tel 				= "'.$_POST['tel'].'",'.
				'address			= "'.$_POST['address'].'",'.
				'date_start			= '.$date_start.','.
				'date_exp			= '.$date_exp.','.
				'credit				= '.$credit.','.
				'is_member			= "'.$_POST['is_member'].'" '.
			'WHERE '.
				'id					= "'.$_POST['id'].'" ';
	
	$query = mysql_query($sql) or die(mysql_error());
		
	// Report
	$css		= '../css/style.css';
	$url_target	= 'customer.php';
	$title		= 'สถานะการทำงาน';
	$message	= '<li class="green">ปรับปรุงข้อมูลเสร็จสมบูรณ์</li>';
	
	require_once("../iic_tools/views/iic_report.php");
	exit();
}
	
$sql	= 'SELECT * FROM customer WHERE id = '.$_GET['id'];
$query	= mysql_query($sql);
$data	= mysql_fetch_array($query);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>แก้ไขข้อมูลลูกค้า</title>
<?php include('inc.css.php'); ?>
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script type="text/javascript"src="../js/jquery-ui-1.8.11.min.js"></script>

<!-- jQuery - Form validate -->
<link rel="stylesheet" type="text/css" href="../iic_tools/css/jquery.validate.css" />
<script type="text/javascript" src="../iic_tools/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="../iic_tools/js/jquery.validate.additional-methods.js"></script>
<script type="text/javascript" src="../iic_tools/js/jquery.validate.messages_th.js"></script>
<script type="text/javascript" src="../iic_tools/js/jquery.validate.config.js"></script>

<!-- jQuery - Internal -->
<script type="text/javascript">
$(function()
{
	// Select menu
	$("#menu a:eq(1)").addClass('active');
	
	// Validate form
	$("form").validate({
		rules: {
				   tel: {
							required	: true,
							minlength	: 9,
							digits		: true,
							messages	: {
											  required	: 'โปรดระบุหมายเลขโทรศัพท์ที่ถูกต้อง',
											  minlength	: 'โปรดระบุหมายเลขโทรศัพท์ที่ถูกต้อง',
											  digits	: 'โปรดระบุหมายเลขโทรศัพท์ที่ถูกต้อง'
										  }
						}
				}
	});
	
	// Set datepicker
	$.datepicker.setDefaults(
	{
		changeMonth	: true,
		changeYear	: true,
		dateFormat	: 'yy-mm-dd'
	});
	
	$("#date_register").datepicker();
	$("#date_start").datepicker();
	$("#date_exp").datepicker();
	
	$('#label_member').click(function()
	{
		$("#date_start").datepicker("setDate" , 'y-m-d');
		$("#date_exp").datepicker("setDate" , '+1m');
	});
	
	$('label[for=normal]').click(function()
	{
		$("#date_start").val('');
		$("#date_exp").val('');
	});
});
</script>
</head>
<body>
<div id="container">
	<?php include('inc.header.php'); ?>
	<div id="content">
		<?php 
		if($data['is_member'] == 1)
		{
			echo '<a href="customer_print_receipt.php" class="button float_r">พิมพ์ใบเสร็จรับเงิน</a>';	
		}
		?>
		<h1>แก้ไขข้อมูลลูกค้า</h1>
		<hr />
		<form method="post" action="">
			<label for="name">ชื่อ : </label>
			<input id="name" name="name" type="text" value="<?php echo $data['name'] ?>" class="required letters_only" />
			<label for="lastname">นามสกุล : </label>
			<input id="lastname" name="lastname" type="text" value="<?php echo $data['lastname'] ?>" class="required letters_only" />
			<label for="nickname">ชื่อเล่น : </label>
			<input id="nickname" name="nickname" type="text" value="<?php echo $data['nickname'] ?>" class="required letters_only" />
			<label for="address">ที่อยู่ : </label>
			<textarea id="address" name="address"><?php echo $data['address'] ?></textarea>
			<label for="tel">เบอร์โทรศัพท์ : </label>
			<input id="tel" name="tel" type="text" value="<?php echo $data['tel'] ?>" />
			<label for="date_register">วันที่สมัคร : </label>
			<input name="date_register" type="text" id="date_register" value="<?php echo $data['date_register'] ?>" readonly="readonly" />
			<label for="date_start">วันที่ต่อายุ : </label>
			<input id="date_start" name="date_start" type="text" value="<?php echo $data['date_start'] ?>" readonly="readonly" />
			<label for="date_exp">วันหมดอายุ : </label>
			<input name="date_exp" type="text" id="date_exp" value="<?php echo $data['date_exp'] ?>" readonly="readonly" />
			<label>
				ประเภทลูกค้า :
				<label id="label_normal" for="normal" class="normal">
					<input id="normal" name="is_member" type="radio" value="0" <?php if($data['is_member'] == 0) echo 'checked="checked"'; ?> />
					ทั่วไป</label>
				<label id="label_member" for="member" class="normal">
					<input id="member" name="is_member" type="radio" value="1" <?php if($data['is_member'] == 1) echo 'checked="checked"'; ?> />
					รายเดือน</label>
			</label>
			<input name="id" type="hidden" value="<?php echo $_GET['id'] ?>" />
			<label class="center">
				<input id="submit" name="submit" type="submit" value="บันทึก" />
			</label>
			<hr />
			<a href="customer.php">กลับ</a>
		</form>
	</div>
	<?php include("inc.footer.php"); ?>
</div>
</body>
</html>