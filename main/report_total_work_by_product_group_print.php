<?php 
require("../include/session.php");
require('../include/connect.php');

$sql 	= 'SELECT
			  (SELECT SUM(quantity) FROM order_item LEFT JOIN order_head ON order_item.id_order = order_head.id WHERE order_head.id_product_group = 1 AND order_head.date_create BETWEEN "'.$_POST['date_start'].' 00:00:00" AND "'.$_POST['date_end'].' 23:59:59") AS normal,
			  (SELECT SUM(quantity) FROM order_item LEFT JOIN order_head ON order_item.id_order = order_head.id WHERE order_head.id_product_group = 2 AND order_head.date_create BETWEEN "'.$_POST['date_start'].' 00:00:00" AND "'.$_POST['date_end'].' 23:59:59") AS bedding,
			  (SELECT SUM(quantity) FROM order_item LEFT JOIN order_head ON order_item.id_order = order_head.id WHERE order_head.id_product_group = 3 AND order_head.date_create BETWEEN "'.$_POST['date_start'].' 00:00:00" AND "'.$_POST['date_end'].' 23:59:59") AS manual
		   ';
		   
//echo $sql;
		   
$query	= mysql_query($sql) or die(mysql_error());
$data	= mysql_fetch_array($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>รายงานปริมาณผ้าแต่ละชนิดที่ได้ให้บริการไป</title>
<?php include("inc.css.php"); ?>
<style type="text/css" media="print">
#paper
{
	width: 16cm;
	min-height: 24.7cm;
	padding: 2.5cm;
	position: relative;
}
</style>
<style type="text/css" media="screen">
#paper
{
	background: #FFF;
	border: 1px solid #666;
	margin: 20px auto;
	width: 21cm;
	min-height: 27cm;
	padding: 50px;
	position: relative;
	/* CSS3 */
	
	box-shadow: 0px 0px 5px #000;
	-moz-box-shadow: 0px 0px 5px #000;
	-webkit-box-shadow: 0px 0px 5px #000;
}
</style>
<style type="text/css" >
#paper h3 { margin-bottom: 0px; }

#paper li
{
	list-style: decimal;
	margin: 5px 0px 5px 30px;
	position: relative;
}

#paper li span
{
	position: absolute;
	right: -80px;
}

#paper textarea
{
	margin-bottom:25px;
	width: 50%;
}

#paper table, #paper th, #paper td { border: none; }
</style>
</head>

<body>
<div id="paper">
	<table width="100%">
		<tr>
			<td colspan="3" align="right">วันที่ <?php echo change_date_format(date('Y-m-d')); ?></td>
		</tr>
		<tr>
			<td colspan="3"><h1 align="center">รายงานปริมาณผ้าแต่ละชนิดที่ได้ให้บริการไป</h1></td>
		</tr>
		<tr>
			<td colspan="3" align="center"><h5>ช่วงวันที่ &nbsp;&nbsp;&nbsp;<?php echo change_date_format($_POST['date_start']); ?> &nbsp;&nbsp;&nbsp;ถึงวันที่ &nbsp;&nbsp;&nbsp;<?php echo change_date_format($_POST['date_end']); ?></h5></td>
		</tr>
		<tr>
			<td colspan="2"><h3>ทั่วไป</h3></td>
			<td width="80" align="right"><h3>&nbsp;</h3></td>
		</tr>
		<tr>
			<td colspan="3"><hr /></td>
		</tr>
		<tr>
			<td colspan="2"><ol>
					<?php 
				$sql = 'SELECT 
							product.*,
							(
								SELECT SUM(order_item.quantity)
								
								FROM order_item 
								
								LEFT JOIN order_head 
								ON order_item.id_order = order_head.id
								
								WHERE
									id_product = product.id
									AND
									order_head.date_create BETWEEN "'.$_POST['date_start'].' 00:00:00" AND "'.$_POST['date_end'].' 23:59:59"
							) AS total
						
						FROM product
						 
						WHERE 
							id_product_group = 1 
							
						ORDER BY product.name ASC';
						
				$query = mysql_query($sql) or die(mysql_error());
				while($row = mysql_fetch_assoc($query))
				{
					$row['total'] = ($row['total'] == '') ? 0 : $row['total'];
					
					echo '<li>'.$row['name'].'<span>'.$row['total'].' &nbsp;&nbsp;ชิ้น</span></li>';
				}
				?>
				</ol></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2" align="right"><h3>รวม</h3></td>
			<td align="right"><h3><?php echo $data['normal']; ?> &nbsp;ชิ้น</h3></td>
		</tr>
		<tr>
			<td colspan="3"><hr /></td>
		</tr>
		<tr>
			<td colspan="2"><h3>ชุดเครื่องนอน</h3></td>
			<td align="right"><h3>&nbsp;</h3></td>
		</tr>
		<tr>
			<td colspan="3"><hr /></td>
		</tr>
		<tr>
			<td colspan="2"><ol>
					<?php 
				$sql = 'SELECT 
							product.*,
							(
								SELECT SUM(order_item.quantity)
								
								FROM order_item 
								
								LEFT JOIN order_head 
								ON order_item.id_order = order_head.id
								
								WHERE
									id_product = product.id
									AND
									order_head.date_create BETWEEN "'.$_POST['date_start'].'" AND "'.$_POST['date_end'].'"
							) AS total 
						
						FROM product
						 
						WHERE 
							id_product_group = 2 
							
						ORDER BY product.name ASC';
						
				$query = mysql_query($sql) or die(mysql_error());
				while($row = mysql_fetch_assoc($query))
				{
					$row['total'] = ($row['total'] == '') ? 0 : $row['total'];
					
					echo '<li>'.$row['name'].'<span>'.$row['total'].' &nbsp;&nbsp;ชิ้น</span></li>';
				}
				?>
				</ol></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2" align="right"><h3>รวม</h3></td>
			<td align="right"><h3><?php echo $data['bedding']; ?> &nbsp;ชิ้น</h3></td>
		</tr>
		<tr>
			<td colspan="3"><hr /></td>
		</tr>
		<tr>
			<td><h3>ซักมือ</h3></td>
			<td align="right"><h3>รวม</h3></td>
			<td align="right"><h3><?php echo $data['manual']; ?> &nbsp;ชิ้น</h3></td>
		</tr>
		<tr>
			<td colspan="3" align="right"><hr /></td>
		</tr>
		<tr>
			<td colspan="2" align="right"><h3>รวมทั้งหมด</h3></td>
			<td align="right"><h3><?php echo ($data['normal'] + $data['bedding'] + $data['manual']); ?> &nbsp;ชิ้น</h3></td>
		</tr>
	</table>
</div>
</body>
</html>