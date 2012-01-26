<?php require_once("../include/session.php"); ?>
<?php
require_once('../include/connect.php');

// --------------------------------------------------------------------------------
// Update order data 
// --------------------------------------------------------------------------------

if(isset($_POST['submit']))
{
	$due_date = $_POST['date_due'].' '.$_POST['due_time'];
	
	//echo $due_date;
	//exit();
	
	$sql = 'UPDATE order_head 
			SET	
				date_due = "'.$due_date.'"
			WHERE 
				id = "'.$_POST['id'].'"';
				
	//echo $sql;
	//exit();
	
	$query = mysql_query($sql) or die(mysql_error());

	// --------------------------------------------------------------------------------
	// Report
	// --------------------------------------------------------------------------------
	
	$css			= '../css/style.css';
	$url_target		= 'order.php';
	$title			= 'สถานะการทำงาน';
	$message		= '<li class="green">ปรับปรุงข้อมูลเสร็จสมบูรณ์</li>';
	
	require_once("../iic_tools/views/iic_report.php");
	exit();
		
	// --------------------------------------------------------------------------------
	// End
	// --------------------------------------------------------------------------------
}

// --------------------------------------------------------------------------------
// Get order data 
// --------------------------------------------------------------------------------

$sql = 'SELECT 
			order_head.*,
			order_type.name AS "order_type",
			customer.name AS "name",
			customer.lastname AS "lastname",
			customer.nickname AS "nickname"
				
		FROM order_head
	  
		LEFT JOIN order_type
		ON order_head.id_order_type = order_type.id
	  
		LEFT JOIN customer
		ON order_head.id_customer = customer.id
	  
		WHERE 
			order_head.id = "'.$_GET['id'].'"';
			
$query	= mysql_query($sql) or die(mysql_error());
$data	= mysql_fetch_array($query);

@list($create_date, $create_time) = explode(' ', $data['date_create']);

$create_time = substr($create_time, -8, 5);

@list($due_date, $due_time) = explode(' ', $data['date_due']);

// --------------------------------------------------------------------------------
// End 
// --------------------------------------------------------------------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Order Edit</title>
<?php include('inc.css.php'); ?>
<style type="text/css">
a.float_r { margin-left: 20px; }

#id_customer { min-width: 40px; width: 40px; text-align: center; }
#name { min-width: 180px; width: 180px; }
#nickname { min-width: 60px; width: 60px; }

form input[type=text].date_inline,
form input[type=text].time_inline
{ 
	min-width: 80px; 
	width: 80px; 
	text-align: center 
}
form select.time_inline 
{ 
	min-width: 90px; 
	width: 90px; 
	text-align: center 
}

</style>
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script src="../js/jquery-ui-1.8.11.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	$('#date_due').datepicker({"dateFormat": 'yy-mm-dd'});
});
</script>
</head>
<body>
<div id="container">
	<?php include('inc.header.php'); ?>
	<div id="content">
		<a href="order.php" class="button float_r">พิมพ์ใบเสร็จรับเงิน</a>
		<a href="order.php" class="button float_r">พิมพ์ใบรายการ</a> 
		<h1>แก้ไขใบรายการ</h1>
		<hr />
		<form action="" method="post">
			<label for="id_order">รหัสใบรายการ</label>
			<input id="id_order" name="id_order" type="text" value="<?php echo zero_fill(6, $data['id']); ?>" readonly="readonly" />
			<label for="order_type">ประเภทใบรายการ</label>
			<input id="order_type" name="order_type" type="text" value="<?php echo $data['order_type'] ?>" readonly="readonly" />
			<label for="id_customer">รหัส - ชื่อ นามสกุล - ชื่อเล่น</label>
			<input id="id_customer" name="id_customer" type="text" value="<?php echo zero_fill(4, $data['id_customer']); ?>" readonly="readonly" /> -
			<input id="name" name="name" type="text" value="<?php echo $data['name'].' '.$data['lastname']; ?>" readonly="readonly" /> - 
			<input id="nickname" name="nickname" type="text" value="<?php echo $data['nickname']; ?>" readonly="readonly" />
			<label for="total_item">จำนวนผ้า (ชิ้น)</label>
			<input id="total_item" name="total_item" type="text" value="<?php echo $data['total_item']; ?>" readonly="readonly" />
			<label for="total_price">จำนวนเงิน (บาท)</label>
			<input id="total_price" name="total_price" type="text" value="<?php echo $data['total_price']; ?>" readonly="readonly" />
			<label for="date_create">วันที่ทำรายการ</label>
			<input id="date_create" name="date_create" type="text" value="<?php echo $create_date; ?>" readonly="readonly" class="date_inline" />
			<input id="time_create" name="time_create" type="text" value="<?php echo $create_time; ?>" readonly="readonly" class="time_inline" />
			<label for="date_due">วันที่รับของ</label>
			<input id="date_due" name="date_due" type="text" value="<?php echo $due_date; ?>" readonly="readonly" class="date_inline" />
			<select id="due_time" name="due_time" class="time_inline">
				<?php 						
				$sql	= 'SELECT * FROM queue_time ORDER BY id';
				$query	= mysql_query($sql) or die(mysql_error());
				
				while($data_queue_time = mysql_fetch_array($query))
				{
					$selected = ($data_queue_time['time_start'] == $due_time) ? 'selected="selected"' : '';
					
					echo '<option value="'.$data_queue_time['time_start'].'" '.$selected.'>'.substr($data_queue_time['time_start'], -8, 5).'</option>';
				}  
				?>
			</select>
			<label for="id_order_status">สถานะ :</label>
			<select id="id_order_status" name="id_order_status">
				<?php 		
				$sql	= 'SELECT * FROM order_status ORDER BY order_status.id';
				$query	= mysql_query($sql) or die(mysql_error());
				
				while($data_status = mysql_fetch_array($query))
				{
					$selected = ($data_status['id'] == $data['id_order_status']) ? 'selected="selected"' : '';
					
					echo '<option value="'.$data_status['id'].'" '.$selected.'>'.$data_status['name'].'</option>';
				}  
				
				?>
			</select>
			<label class="center">
				<input name="id" type="hidden" value="<?php echo $_GET['id']; ?>" />
				<input name="submit" type="submit" id="submit" value="บันทึก" />
			</label>
			<hr />
			<a href="order.php">กลับ</a>
		</form>
	</div>
	<?php include("inc.footer.php"); ?>
</div>
</body>
</html>