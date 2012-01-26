<?php require_once("../include/session.php"); ?>
<?php require_once('../include/connect.php');?>

<?php 
if(isset($_POST['submit']))
{  
	//print_array($_POST);
	//exit();
	
	// ------------------------------------------------------------------------
	// Update receive
	// ------------------------------------------------------------------------

	$sql = 'UPDATE order_head 
				SET
					is_receive		= "'.$_POST['is_receive'].'" '.
					'WHERE '.
					'id					= "'.$_POST['id'].'" ';
					
					//echo $sql;
											
				
		$query = mysql_query($sql)or die(mysql_error());
	
		// Report
		$css 		= '../css/style.css';
		$url_target	= 'receive.php';
		$title		= 'สถานะการทำงาน';
		$message	= '<li class="green">บันทึกข้อมูลเสร็จสมบูรณ์</li>';
		
		require_once("../iic_tools/views/iic_report.php");
		exit();
}
$sql	= 'SELECT * FROM order_head WHERE id = '.$_GET['id'];
$query	= mysql_query($sql) or die(mysql_error());
$data	= mysql_fetch_array($query);		
?>       
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>การรับผ้า</title>
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script type="text/javascript">
$(function(){
	$("a#receive1").addClass('active');
});
</script>
<?php include('inc.css.php'); ?>
<style type="text/css">
</style>
</head>

<body>
<div id="container">
	<?php include('inc.header.php'); ?>
    <div id="content">
        <h1>การรับผ้า</h1>
        <hr />
        <form method="post" action="receive1.php">
        
        <label for="notreceive" class="normal">
        <input id="notreceive" name="is_receive" type="radio" value="0" checked="checked" />รอรับผ้า</label>
          
        <label for="receive" class="normal">
        <input id="receive" name="is_receive" type="radio" value="1" />รับผ้าแล้ว</label>
    	
        <input name="id" type="hidden" value="<?php echo $_GET['id'] ?>" />
        <label class="center">
        <input name="submit" type="submit" id="submit" value="บันทึก" />
        </label>
        <p><a href="receive.php" class="">กลับ</a> </p>
        </form>
    </div>
    <?php include("inc.footer.php"); ?>
</div>
</body>
</html>