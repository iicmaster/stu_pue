<?php 
require_once("../include/session.php"); 
require_once("../include/connect.php");

if(isset($_POST['submit']))
{ 
	$message = '';

	// --------------------------------------------------------------------------------
	// Start transaction
	// --------------------------------------------------------------------------------
	
	mysql_query("BEGIN");

	// --------------------------------------------------------------------------------
	// Step 1 - Add transection
	// --------------------------------------------------------------------------------
		
	// Check action
	$amount = ($_POST['action'] == 0) ? 0 + $_POST['amount'] : 0 - $_POST['amount'];
	
	$sql = 	'INSERT INTO inventory_transaction  
			 SET 
					id_inventory	= "'.$_POST['id_inventory'].'",
					amount			= "'.$amount.'",
					description		= "'.$_POST['description'].'"';
	
	if( ! $query = mysql_query($sql))
	{
		// RollBack transaction and show error message when query error						
		if( ! $query = mysql_query($sql))
		{
			echo 'Step 1 - Add transection';
			echo '<hr />';
			echo mysql_error();
			echo '<hr />';
			echo $sql;
			mysql_query("ROLLBACK");
			exit();
		};
	}

	// --------------------------------------------------------------------------------
	// Step 2 - update amount
	// --------------------------------------------------------------------------------
	
	$sql =	'UPDATE inventory 
			 SET 
				total = total + "'.$amount.'"
			 WHERE 
				id = "'.$_POST['id_inventory'] .'"';
	
	if( ! $query = mysql_query($sql))
	{
		// RollBack transaction and show error message when query error						
		if( ! $query = mysql_query($sql))
		{
			echo 'Step 2 - update amount';
			echo '<hr />';
			echo mysql_error();
			echo '<hr />';
			echo $sql;
			mysql_query("ROLLBACK");
			exit();
		};
	}
	
	$message .= '<li class="green">ปรับปรุงยอดวัตถุดิบเสร็จสมบูรณ์</li>';
	
	// --------------------------------------------------------------------------------
	// Commit transaction
	// --------------------------------------------------------------------------------
	
	mysql_query("COMMIT");
	
	// --------------------------------------------------------------------------------
	// Report
	// --------------------------------------------------------------------------------
	
	$css		= '../css/style.css';
	$url_target = 'inventory.php';
	$title 		= 'สถานะการทำงาน';
	
	require_once("../iic_tools/views/iic_report.php");
	exit();
	
	// --------------------------------------------------------------------------------
	// End
	// --------------------------------------------------------------------------------
}

// --------------------------------------------------------------------------------
// Get inventory data
// --------------------------------------------------------------------------------

$sql	= 'SELECT 
				inventory.*,
				inventory_unit.name AS "unit"
				
		   FROM inventory 
		   
		   LEFT JOIN inventory_unit
		   ON inventory.id_inventory_unit = inventory_unit.id
		   
		   WHERE 
		   	   	inventory.id = "'.$_GET['id'].'"';
		   
$query	= mysql_query($sql) or die(mysql_error());
$data	= mysql_fetch_array($query);

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
	text-align:right;
}
</style>
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script type="text/javascript">
$(function(){
	$("#menu a#material").addClass('active');
});
</script>
</head>
<body>
<div id="container">
	<?php include('inc.header.php'); ?>
	<div id="content">
		<h1>เพิ่ม/ลด จำนวนวัตถุดิบ</h1>
		<hr />
		<form method="post" action="inventory_transaction_create.php">
			<label>วัตถุดิบ: <span class="normal"><?php echo $data['name'] ?></span></label>
			<label for="action">การดำเนินการ :</label>
			<label class="normal">	<input type="radio" id="deposit" name="action" value="0" />เพิ่ม</label>
				<label class="normal"><input type="radio" id="withdraw" name="action" value="1" />ลด</label>
			<label for="amount">จำนวน:</label>
			<input id="amount" name="amount" type="text" value="" />
			<?php echo $data['unit'] ?>
			<label for="description">คำอธิบาย:</label>
			<textarea id="description" name="description"></textarea>
			<input name="id_inventory" type="hidden" value="<?php echo $_GET['id'] ?>">
			<label class="center">
				<input name="submit" type="submit" id="submit" value="บันทึก" />
			</label>
			<hr />
			<a href="inventory.php">กลับ</a>
		</form>
	</div>
	<hr />
	<?php include("inc.footer.php"); ?>
</div>
</body>
</html>