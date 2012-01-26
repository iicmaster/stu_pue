<?php 
require_once("../include/session.php"); 
require_once("../include/connect.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>งานทั้งหมดที่ได้ทำลงไป</title>
<?php include('inc.css.php'); ?>
<style type="text/css">
form input[type=text], form select
{
	margin-left: 0px;
	min-width: 200px;
}
</style>
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script type="text/javascript"src="../js/jquery-ui-1.8.11.min.js"></script>
<script type="text/javascript">
$(function()
{
	$("#menu a#report").addClass('active');

	// Set datepicker
	$.datepicker.setDefaults(
	{
		changeMonth	: true,
		changeYear	: true,
		dateFormat	: 'yy-mm-dd'
	});
	
	$("#date_start").datepicker();
	$("#date_end").datepicker();
});
</script>
</head>

<body>
<div id="container">
	<?php include('inc.header.php'); ?>
	<div id="content">
		<h1>งานทั้งหมดที่ได้ทำลงไป</h1>
		<hr />
		<form method="post" action="report_total_work_print.php" target="_blank">
			<label for="date_start" class="normal inline"> ข่วงวันที่ :</label>
			<input type="text" name="date_start" id="date_start" />
			<label for="date_end" class="normal inline"> ถึงวันที่ : &nbsp;</label>
			<input type="text" name="date_end" id="date_end" />
			<label for="id_product_group" class="">ประเภทผ้า : 
			<select id="id_product_group" name="id_product_group">
				<?php 
				// Select type of order item
				$sql = 'SELECT * FROM product_group';
				$query = mysql_query($sql) or die(mysql_error());
						
				while($data = mysql_fetch_array($query))
				{
					echo '<option value="'.$data['id'].'">'.$data['name'].'</option>';
				}
				?>
			</select></label>
			<label for="id_order_type">ประเภทใบรายการ : 
			<select id="id_order_type" name="id_order_type" >
				<?php 
				$sql = 'SELECT * FROM order_type';
				$query = mysql_query($sql) or die(mysql_error());
						
				while($data = mysql_fetch_array($query))
				{
					echo '<option value="'.$data['id'].'">'.$data['name'].'</option>';
				}
				?>
			</select></label>
			<div>
				<input type="submit" value="ออกรายงาน" />
			</div>
		</form>
	</div>
	<?php include("inc.footer.php"); ?>
</div>
</body>
</html>
