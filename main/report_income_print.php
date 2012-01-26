<?php 
require("../include/session.php");
require('../include/connect.php');

$sql 	= 'SELECT
			  (SELECT SUM(amount) FROM customer_receipt WHERE id_receipt_type = 2 AND date_create BETWEEN "'.$_POST['date_start'].' 00:00:00" AND "'.$_POST['date_end'].' 23:59:59") AS member,
			  (SELECT SUM(total_price) FROM order_head WHERE id_order_type = 1 AND id_product_group != 3 AND date_create BETWEEN "'.$_POST['date_start'].' 00:00:00" AND "'.$_POST['date_end'].' 23:59:59") AS wash_dry_iron,
			  (SELECT SUM(total_price) FROM order_head WHERE id_order_type = 2 AND id_product_group != 3 AND date_create BETWEEN "'.$_POST['date_start'].' 00:00:00" AND "'.$_POST['date_end'].' 23:59:59") AS wash_dry,
			  (SELECT SUM(total_price) FROM order_head WHERE id_order_type = 3 AND id_product_group != 3 AND date_create BETWEEN "'.$_POST['date_start'].' 00:00:00" AND "'.$_POST['date_end'].' 23:59:59") AS iron,
			  (SELECT SUM(total_price) FROM order_head WHERE id_product_group = 3 AND date_create BETWEEN "'.$_POST['date_start'].' 00:00:00" AND "'.$_POST['date_end'].' 23:59:59") AS wash_manual';
		   
//echo $sql;
		   
$query	= mysql_query($sql) or die(mysql_error());
$data	= mysql_fetch_assoc($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ใบรายการ</title>
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
}

#paper textarea
{
	margin-bottom:25px;
	width: 50%;
}

#paper table, #paper th, #paper td { border: none; }

#paper table.border, #paper table.border th, #paper table.border td { border: 1px solid #666; }

#paper th
{
	background: none;
	color: #000
}

#paper hr { border-style: solid; }
</style>
</head>

<body>
<div id="paper">
	<table width="100%">
		<tr>
			<td width="80" align="right">วันที่ <?php echo change_date_format(date('Y-m-d')); ?></td>
		</tr>
		<tr>
			<td><h1 align="center">รายงานรายได้</h1></td>
		</tr>
		<tr>
			<td align="center"><h5>ช่วงวันที่ &nbsp;&nbsp;&nbsp;<?php echo change_date_format($_POST['date_start']); ?> &nbsp;&nbsp;&nbsp;ถึงวันที่ &nbsp;&nbsp;&nbsp;<?php echo change_date_format($_POST['date_end']); ?></h5></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>
	<table width="100%" class="border">
		<thead>
			<tr>
				<th>รายการ</th>
				<th width="80">จำนวนเงิน (บาท)</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>รายได้จากค่าสมาชิก</td>
				<td align="right"><?php echo add_comma($data['member']); ?></td>
			</tr>
			<tr>
				<td>รายได้จากงาน ซัก - อบ - รีด</td>
				<td align="right"><?php echo add_comma($data['wash_dry_iron']); ?></td>
			</tr>
			<tr>
				<td>รายได้จากงาน ซัก - อบ</td>
				<td align="right"><?php echo add_comma($data['wash_dry']); ?></td>
			</tr>
			<tr>
				<td>รายได้จากงาน รีด</td>
				<td align="right"><?php echo add_comma($data['iron']); ?></td>
			</tr>
			<tr>
				<td>รายได้จากงาน ซักมือ</td>
				<td align="right"><?php echo add_comma($data['wash_manual']); ?></td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td align="right">รวม</td>
				<td align="right"><?php echo add_comma(array_sum($data)); ?> &nbsp;บาท</td>
			</tr>
		</tfoot>
	</table>
</div>
</body>
</html>