<?php require_once("../include/session.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>วัตถุดิบ</title>
<?php include('inc.css.php'); ?>
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
	<div id="content"> <a href="inventory_create.php" class="button float_r">เพิ่มวัตถุดิบ</a>
		<h1>วัตถุดิบ</h1>
		<hr />
		<table width="100%" border="1" align="center" cellpadding="5" cellspacing="0">
			<thead>
				<tr>
					<th scope="col">รหัส</th>
					<th scope="col">วัตถุดิบ</th>
					<th scope="col">ยี่ห้อ</th>
					<th scope="col">ขนาด</th>
                    <th scope="col">ราคา</th>
					<th scope="col">จำนวนคงเหลือ</th>
					<th scope="col">หน่วย</th>
					<th scope="col">ปรับปรุงข้อมูลล่าสุด</th>
					<th scope="col">การดำเนินการ</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				include_once('../include/connect.php');
				
				$sql = 'SELECT 
							inventory.*,
							inventory_unit.name as unit
							
						FROM inventory
						
						LEFT JOIN inventory_unit
						ON inventory.id_inventory_unit = inventory_unit.id';
						
				$query = mysql_query($sql) or die(mysql_error());
				$query_rows = mysql_num_rows($query);
				
				if($query_rows > 0)
				{
					while($data = mysql_fetch_array($query))
					{
						echo '	<tr>
									<td class="center">'.$data['id'].'</td>
									<td>'.$data['name'].'</td>
									<td>'.$data['brand'].'</td>
									<td class="right">'.$data['volume'].'</td>
									<td class="right">'.$data['price'].'</td>
									<td class="right">'.add_comma($data['total']).'</td>
									<td class="right">'.$data['unit'].'</td>
									<td align="center">'.change_date_time_format($data['date_update']).'</td>
									<td class="center">
										<a href="inventory_transaction_create.php?id='.$data['id'].'">เพิ่ม/ลด<a> |
										<a href="inventory_read.php?id='.$data['id'].'">ดู</a> |
										<a href="inventory_update.php?id='.$data['id'].'">แก้ไข</a> |
										<a href="inventory_delete.php?id='.$data['id'].'">ลบ</a> 
									</td>
								</tr>';
					}
				}
				else
				{
					echo '<tr><td colspan="7" class="center">ไม่มีข้อมูล</td></tr>';
				}
				?>
			</tbody>
		</table>
	</div>
	<?php include("inc.footer.php"); ?>
</div>
</body>
</html>
