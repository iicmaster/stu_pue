<?php 
require_once("../include/session.php");
require_once("../include/connect.php");

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
<title>ข้อมูลวัตถุดิบ</title>
<?php include('inc.css.php'); ?>
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script type="text/javascript">
$(function(){
	$("#menu a#material").addClass('active');
});
</script>
<style type="text/css" media="print">

</style>
</head>
<body>
<div id="container">
	<?php include('inc.header.php'); ?>
<div id="content">
		<h1>ข้อมูลวัตถุดิบ</h1>
		<hr />
		<form method="post" action="">
			<p><strong>วัตถุดิบ : </strong><?php echo $data['name']; ?></p>
			<p><strong>ยี่ห้อ : </strong><?php echo $data['brand']; ?></p>
			<p><strong>หน่วย : </strong><?php echo $data['unit']; ?></p>
			
</form>
		<hr style="margin-top:20px;" />
		<table width="100%">
			<tr>
				<th>วันที่ - เวลา</th>
				<th>คำอธิบาย</th>
				<th>เพิ่ม</th>
				<th>ลด</th>
			</tr>
			<?php 
			$sql = 'SELECT * 
					FROM inventory_transaction 
					WHERE id_inventory = "'.$_GET['id'].'"
					ORDER BY date_create DESC';
					
			$query = mysql_query($sql) or die(mysql_error());
			$query_rows = mysql_num_rows($query);
			
			if($query_rows > 0)
			{
				while($data = mysql_fetch_array($query))
				{
					if($data['amount'] > 0)
					{
						$deposit   = add_comma($data['amount']);
						$withdraw  = '';
					}
					else
					{
						$deposit   = '';
						$withdraw  = add_comma(abs($data['amount']));
					}
					
					echo '<tr>
							  <td>'.change_date_time_format($data['date_create']).'</td>
							  <td>'.$data['description'].'</td>
							  <td class="right">'.$deposit.'</td>
							  <td class="right">'.$withdraw.'</td>
						  </tr>';
				}
			}
			else
			{
				echo '<tr><td colspan="4" class="center">ไม่มีข้อมูล</td></tr>';
			}
			?>
		</table>
		<hr />
		<a href="inventory.php">กลับ</a>
	</div>
	<?php include("inc.footer.php"); ?>
</div>
</body>
</html>