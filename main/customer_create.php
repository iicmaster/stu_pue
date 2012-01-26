<?php 
require_once("../include/session.php"); 
require_once("../include/connect.php");

if(isset($_POST['submit']))
{
	require_once("../include/connect.php");
	
	$message = '';
				
	$credit		= ($_POST['is_member'] == 1) ? 50 : 0;
	$date_start	= ($_POST['is_member'] == 1) ? '"'.date('Y-m-d').'"' : 'NULL';
	$date_exp	= ($_POST['is_member'] == 1) ? '"'.date('Y-m-d', strtotime('+1 months')).'"' : 'NULL';
		
	// ----------------------------------------------------------------------------
	// Start transaction
	// ----------------------------------------------------------------------------
	
		mysql_query("BEGIN");	
		
	// ----------------------------------------------------------------------------
	// Create customer
	// ----------------------------------------------------------------------------
	
		$sql = 'INSERT INTO customer 
				SET
					name			= "'.$_POST['fname'].'", 
					lastname		= "'.$_POST['lastname'].'", 
					nickname		= "'.$_POST['nickname'].'", 
					tel				= "'.$_POST['tel'].'", 
					address			= "'.$_POST['addr'].'", 
					date_register	= "'.date('Y-m-d').'", 
					date_start		= '.$date_start.', 
					date_exp		= '.$date_exp.',
					credit			= "'.$credit.'",
					is_member		= "'.$_POST['is_member'].'"';
											
		// RollBack transaction and show error message when query error						
		if( ! $query = mysql_query($sql))
		{
			echo 'Create customer';
			echo '<hr />';
			echo mysql_error();
			echo '<hr />';
			echo $sql;
			mysql_query("ROLLBACK");
			exit();
		}
	
	// ----------------------------------------------------------------------------
	// Get customer id
	// ----------------------------------------------------------------------------
		
		$sql = 'SELECT MAX(id) AS id FROM customer';
								
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
		$id_customer = $data['id'];
		
	// ----------------------------------------------------------------------------
	// Check is member
	// ----------------------------------------------------------------------------
		
	if($_POST['is_member'] == 1)
	{
		// ------------------------------------------------------------------------
		// Create receipt
		// ------------------------------------------------------------------------
		
			$sql = 'INSERT INTO customer_receipt 
					SET
						id_receipt_type	= 2, 
						id_customer		= '.$id_customer.', 
						amount			= 500, 
						date_create		= "'.date('Y-m-d H:i:s').'"';
							
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
	
		$css		= '../css/style.css';
		$url_target	= 'customer.php';
		$title		= 'สถานะการทำงาน';
		$message   .= '<li class="green">เพิ่มข้อมูลเสร็จสมบูรณ์</li>';
		
		require_once("../iic_tools/views/iic_report.php");
		exit();
	
	// ----------------------------------------------------------------------------
	// End
	// ----------------------------------------------------------------------------
}

$sql = 'SELECT MAX(id+1) AS id FROM customer'; 
$query	= mysql_query($sql) or die(mysql_error());
$data	= mysql_fetch_array($query);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>สมัครลูกค้าใหม่</title>
<?php include('inc.css.php'); ?>
<style type="text/css">
#customer_policy 
{ 
	border-right: 1px dashed #CCC;
	float: left; 
	height: 500px;
	margin-right: 25px;
	width: 50%; 
}
#img
{
	border-radius: 10px;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
}
</style>
<!-- jQuery -->
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>

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
});
</script>
</head>
<body>
<div id="container">
	<?php include('inc.header.php'); ?>
	<div id="content">
		<h1>สมัครลูกค้าใหม่</h1>
		<hr />
		<div id="customer_policy">
			<p style="font-size:19px" >โปรโมชั่นแบบรายเดือน</p>
		 	<p style="font-size:15px">สำหรับลูกค้าสมาชิกแบบรายเดือน ซักไม่อั้น 50 ชิ้น ราคา 500 บาท</p>
            <p><img src="../images/DSC02018.JPG" width="400" height="325" id="img"/></p>
		</div> 
      <form method="post" action="customer_create.php">
			
       		<label for="id">รหัส </label>
			<input id="id" type="text" value="<?php echo zero_fill(4, $data['id']); ?>" readonly="readonly"/>
    		<label for="fname">ชื่อ <span class="red">*</span></label>
			<input id="fname" name="fname" type="text" value="" class="required letters_only" />
			<label for="lastname">นามสกุล <span class="red">*</span></label>
			<input id="lastname" name="lastname" type="text" value="" class="required letters_only" />
			<label for="nickname">ชื่อเล่น <span class="red">*</span></label>
			<input id="nickname" name="nickname" type="text" value="" class="required letters_only" />
			<label for="addr">ที่อยู่</label>
			<textarea id="addr" name="addr"></textarea>
			<label for="tel">เบอร์โทรศัพท์ <span class="red">*</span></label>
			<input id="tel" name="tel" type="text" value="" />
			<label>
			ประเภทลูกค้า
			<label for="normal" class="normal">
				<input id="normal" name="is_member" type="radio" value="0" checked="checked" />
				ทั่วไป </label>
			<label for="member" class="normal">
				<input id="member" name="is_member" type="radio" value="1" />
				รายเดือน </label>
			</label>
			<label class="center">
				<input name="submit" type="submit" id="submit" value="บันทึก" />
			</label>
			<hr />
			<a href="customer.php" class="">กลับ</a>
		</form>
	</div>
	<?php include("inc.footer.php"); ?>
</div>
</body>
</html>