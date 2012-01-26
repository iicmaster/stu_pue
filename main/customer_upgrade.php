<?php require_once("../include/session.php"); ?>
<?php
require_once("../include/connect.php");

if(isset($_POST['submit']))
{ 
	$message = '';
	
	$date_start =  date('Y-m-d');
	$date_exp	= date('Y-m-d', strtotime('+1 month'));
	
	$credit = 50;
	
	// ----------------------------------------------------------------------------
	// Start transaction
	// ----------------------------------------------------------------------------
	
		mysql_query("BEGIN");	
		
	// ----------------------------------------------------------------------------
	// Update customer data
	// ----------------------------------------------------------------------------
	
		$sql = 'UPDATE customer 
		
				SET '.
					'date_start	= "'.$date_start.'",'.
					'date_exp	= "'.$date_exp.'",'.
					'credit		= "'.$credit.'",'.
					'is_member	= "'.$_POST['is_member'].'"'.
					
				'WHERE id = "'.$_POST['id'].'" ';
											
		// RollBack transaction and show error message when query error						
		if( ! $query = mysql_query($sql))
		{
			echo 'Update customer data';
			echo '<hr />';
			echo mysql_error();
			echo '<hr />';
			echo $sql;
			mysql_query("ROLLBACK");
			exit();
		}
		
	if($_POST['is_member'] == 1)
	{
		// ------------------------------------------------------------------------
		// Create receipt
		// ------------------------------------------------------------------------
		
			$sql = 'INSERT INTO customer_receipt 
					SET ' .
						'id_customer		= '.$_POST['id'].', '.
						'id_receipt_type	= 2, '.
						'amount				= 500, '.
						'date_create		= "'.date('Y-m-d H:i:s').'"';
							
			// RollBack transaction and show error message when query error						
			if( ! $query = mysql_query($sql))
			{
				echo 'Create receipt';
				echo '<hr />';
				echo mysql_error();
				echo '<hr />';
				echo $sql;
				mysql_query("ROLLBACK");
				exit();
			}
		
		// ------------------------------------------------------------------------
		// Get receipt id
		// ------------------------------------------------------------------------
			
			$sql = 'SELECT MAX(id) AS id FROM customer_receipt';
									
			// RollBack transaction and show error message when query error						
			if( ! $query = mysql_query($sql))
			{
				echo 'Get customer id';
				echo '<hr />';
				echo mysql_error();
				echo '<hr />';
				echo $sql;
				mysql_query("ROLLBACK");
				exit();
			}
			
			$data = mysql_fetch_array($query);
			$id_receipt = $data['id'];
			
		// ------------------------------------------------------------------------
		// Open receipt page
		// ------------------------------------------------------------------------
		
			$message .= '<script type="text/javascript">
							 window.open(\'customer_receipt_print_2.php?id='.$id_receipt.'\', \'_blank\');
						 </script>'; 
	}
	
	// ----------------------------------------------------------------------------
	// Commit transaction
	// ----------------------------------------------------------------------------
	
		mysql_query("COMMIT");

	// ----------------------------------------------------------------------------
	// Report
	// ----------------------------------------------------------------------------
	
		$css			= '../css/style.css';
		$url_target		= 'customer.php';
		$title			= 'สถานะการทำงาน';
		$button_text	= 'เสร็จ';
		$message		.= '<li class="green">สร้างใบรายการเสร็จสมบูรณ์</li>';
		
		require_once("../iic_tools/views/iic_report.php");
		exit();
	
	// ----------------------------------------------------------------------------
	// End
	// ----------------------------------------------------------------------------
}

if(isset($_GET['id']))
{
	$sql	= 'SELECT * FROM customer WHERE id = '.$_GET['id'];
	$query	= mysql_query($sql);
	$data	= mysql_fetch_array($query);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>เปลี่ยนประเภทสมาชิก</title>
<?php include('inc.css.php'); ?>
<!-- jQuery -->
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>

<!-- jQuery UI -->
<script src="../js/jquery-ui-1.8.11.min.js" type="text/javascript"></script>

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
	$("form").validate();
	
	<?php 
	if (isset($_GET['id']))
	{
		echo '$("#id").val('.$_GET['id'].');';
	}
	?>
});
</script>
</head>
<body>
<div id="container">
	<?php include('inc.header.php'); ?>
	<div id="content">
		<h1>เปลี่ยนประเภทสมาชิก</h1>
		<hr />
		<form method="post" action="">
			<label for="id">ชื่อ : </label>
			<select id="id" name="id" class="required" />
				<option value="">-</option>
				<?php 
				
				$sql	= 'SELECT * 
				
						   FROM customer 
								
						   ORDER BY id ASC';
							
				$query	= mysql_query($sql) or die(mysql_error());
				while($data_option = mysql_fetch_array($query))
				{
					
					echo '<option value="'.$data_option['id'].'">'.zero_fill(4, $data_option['id']).' - '.$data_option['name'].' ('.$data_option['nickname'].')</option>';
				}
				?>
			</select>
						<label>
				ประเภทลูกค้า :
				<label id="label_normal" for="normal" class="normal">
					<input id="normal" name="is_member" type="radio" value="0" <?php if($data['is_member'] == 0) echo 'checked="checked"'; ?> />
					ทั่วไป</label>
				<label id="label_member" for="member" class="normal">
					<input id="member" name="is_member" type="radio" value="1" <?php if($data['is_member'] == 1) echo 'checked="checked"'; ?> />
					รายเดือน</label>
			</label>
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