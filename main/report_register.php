<?php require_once("../include/session.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>รายงานการสมัครใหม่ของลูกค้า</title>
<?php include('inc.css.php'); ?>
<style type="text/css">
form input[type=text]
{
	margin-left: 10px;	
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
		<h1>รายงานการสมัครใหม่ของลูกค้า</h1>
		<hr />
		<form method="post" action="report_register_print.php" target="_blank">
			<label class="normal inline"> ข่วงวันที่ :
				<input type="text" name="date_start" id="date_start" />
			</label>
			<label class="normal inline"> ถึงวันที่ : &nbsp;
				<input type="text" name="date_end" id="date_end" />
			</label>
			<div>
				<input type="submit" value="ออกรายงาน" />
			</div>
		</form>
	</div>
	<?php include("inc.footer.php"); ?>
</div>
</body>
</html>
