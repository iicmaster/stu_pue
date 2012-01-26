<?php 
require_once("../include/session.php");
require_once("../include/connect.php");

// --------------------------------------------------------------------------------
// Get customer data
// --------------------------------------------------------------------------------

$sql	= 'SELECT * FROM inventory WHERE id = '.$_GET['id'];
$result = mysql_query($sql) or die(mysql_error());
$data	= mysql_fetch_array($result);

// --------------------------------------------------------------------------------
// End 
// --------------------------------------------------------------------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>เพิ่ม/ลด จำนวนวัตถุดิบ</title>
<?php include('inc.css.php'); ?>
<style type="text/css">
#amount
{
	min-width: 100px;
	margin-right: 10px;
	text-align: right;
}
</style>
</head>
<body>
<div id="container">
	<?php include('inc.header.php'); ?>
	<div id="content">
		<h1>เพิ่ม/ลด จำนวนวัตถุดิบ</h1>
		<hr />
		<form method="post" action="">
			<label>วัตถุดิบ: <span class="normal"><?php echo $data['name'] ?></span></label>
			<label for="action">การดำเนินการ :</label>
			<select id="action" name="action">
				<option value="0">เพิ่ม</option>
				<option value="1">ลด</option>
			</select>
			<label for="amount">จำนวน:</label>
			<input id="amount" name="amount" type="text" value="" /> <?php echo $data['unit'] ?>
			<label for="description">คำอธิบาย:</label>
			<textarea id="description" name="description"></textarea>
			<input name="id_inventory" type="hidden" value="<?php echo $_GET['id'] ?>">
			<label class="center">
				<input name="submit" type="submit" id="submit" value="บันทึก" />
			</label>
			<a href="inventory.php">กลับ</a>
		</form>
	</div>
	<?php include("inc.footer.php"); ?>
</div>
</body>
</html>