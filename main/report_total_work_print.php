<?php 
require("../include/session.php");
require('../include/connect.php');

$sql = 'SELECT 
			order_type.name AS "order_type",
			product_group.name AS "group_name"
			
		FROM order_head
	  
		LEFT JOIN order_type
		ON order_head.id_order_type = order_type.id
		 
		LEFT JOIN product_group
		ON order_head.id_product_group = product_group.id
		
		WHERE 
			order_head.id_product_group = "'.$_POST['id_product_group'].'"
			AND
			order_head.id_order_type = "'.$_POST['id_order_type'].'"';
		   
$query	= mysql_query($sql) or die(mysql_error());
$data	= mysql_fetch_array($query);
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

#paper table.border, #paper table.border th, #paper table.border td { border: 1px solid #666; }

#paper th
{
	background: none;
	color: #000
}

#paper h3 { margin-bottom: 0px; }

#paper ol li
{
	list-style: decimal;
}

#paper li
{
	margin: 5px 0px;
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
			<td width="80" align="right">วันที่ <?php echo change_date_format(date('Y-m-d')); ?></td>
		</tr>
		<tr>
			<td><h1 align="center">รายงานงานทั้งหมดที่ได้ทำลงไป</h1></td>
		</tr>
		<tr>
			<td align="center"><h5>ช่วงวันที่ &nbsp;&nbsp;&nbsp;<?php echo change_date_format($_POST['date_start']); ?> &nbsp;&nbsp;&nbsp;ถึงวันที่ &nbsp;&nbsp;&nbsp;<?php echo change_date_format($_POST['date_end']); ?></h5></td>
		</tr>
		<tr>
			<td align="left"><ul>
				<li>ประเภทผ้า : <?php echo $data['group_name']; ?></li>
				<li>ประเภทงาน : <?php echo $data['order_type']; ?></li>
			</ul></td>
		</tr>
	</table>
	<table width="100%" class="border">
		<thead>
			<tr>
				<th scope="col">ลำดับ</th>
				<th scope="col">วันที่ทำรายการ</th>
				<th scope="col">รหัสใบรายการ</th>
				<th scope="col">ชื่อลูกค้า</th>
				<th scope="col">ประเภทผ้า</th>
				<th scope="col">ประเภทงาน</th>
				<th scope="col">จำนวนชิ้น</th>
				<th scope="col">จำนวนเงิน</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$sql = 'SELECT 
						order_head.*,
						order_type.name AS "order_type",
						customer.name,
						customer.lastname,
						customer.nickname,
						product_group.name AS "group_name",
						order_status.name AS "order_status"
						
					FROM order_head
				  
					LEFT JOIN order_type
					ON order_head.id_order_type = order_type.id
				  
					LEFT JOIN customer
					ON order_head.id_customer = customer.id
					 
					LEFT JOIN product_group
					ON order_head.id_product_group = product_group.id
					  
					LEFT JOIN order_status
					ON order_head.id_order_status = order_status.id
					
					WHERE 
						order_head.date_create BETWEEN "'.$_POST['date_start'].' 00:00:00" AND "'.$_POST['date_end'].' 23:59:59"
						AND
						order_head.id_product_group = "'.$_POST['id_product_group'].'"
						AND
						order_head.id_order_type = "'.$_POST['id_order_type'].'"
				
					ORDER BY order_head.id DESC ';
			
			$query = mysql_query($sql) or die(mysql_error());
			$query_rows = mysql_num_rows($query);
			if($query_rows == 0)
			{
				$total_price[1] = 0;
				$total_item[1] = 0;
			}
			$loop = 1;
			?>
			<?php while($data = mysql_fetch_assoc($query)): ?>
			<?php 
			$total_price[$loop]	= $data['total_price'];
			$total_item[$loop]	= $data['total_item'];
			?>
			<tr>
				<td align="center"><?php echo $loop; ?></td>
				<td align="center"><?php echo change_date_time_format($data['date_create']) ?></td>
				<td align="center"><?php echo zero_fill(6, $data['id']); ?></td>
				<td><?php echo $data['name'].' '.$data['lastname'].' ('.$data['nickname'].')'; ?></td>
				<td align="center"><?php echo $data['group_name']; ?></td>
				<td align="center"><?php echo $data['order_type']; ?></td>
				<td align="center"><?php echo $data['total_item']; ?></td>
				<td align="right"><?php echo add_comma($data['total_price']); ?></td>
			</tr>
			<?php $loop++; ?>
			<?php endwhile; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6" align="center">รวม</td>
				<td align="right"><?php echo array_sum($total_item); ?> ชิ้น</td>
				<td align="right"><?php echo add_comma(array_sum($total_price), 2); ?> บาท</td>
			</tr>
		</tfoot>
	</table>
</div>
</body>
</html>