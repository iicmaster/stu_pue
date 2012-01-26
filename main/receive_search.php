<?php 
/* -------------------------------------------------------------------------------- */
/* Include */
/* -------------------------------------------------------------------------------- */

require_once("../include/session.php"); 
require_once("../include/connect.php");

/* -------------------------------------------------------------------------------- */
/* Update order status */
/* -------------------------------------------------------------------------------- */

// wash-dry-iron, iron
$sql = 'UPDATE order_head
		SET id_order_status = 2
		WHERE date_finish < NOW()';
		
mysql_query($sql) or die(mysql_error()); 

/* -------------------------------------------------------------------------------- */
/* End */
/* -------------------------------------------------------------------------------- */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>การรับผ้า</title>
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script type="text/javascript">
$(function(){
	$("a#receive_search.php").addClass('active');
	
	$("#customer_type").val('<?php echo $_POST['customer_type']; ?>');
	$("#criteria").val('<?php echo $_POST['criteria']; ?>');
});
</script>
<?php include('inc.css.php'); ?>
</head>

<body>
<div id="container">
	<?php include('inc.header.php'); ?>
	<div id="content"> 
		<h1>การรับผ้า</h1>
		<hr />
		<div id="search_section">
			<form method="post" action="receive_search.php">
				<label for="customer_type" class="inline">ค้นหา : </label>
				<select id="customer_type" name="customer_type">
					<option value="0 OR customer.is_member = 1">ลูกค้าทั้งหมด</option>
					<option value="0">ลูกค้าทั่วไป</option>
					<option value="1">ลูกค้ารายเดือน</option>
				</select>
				<label for="criteria" class="inline">จาก : </label>
				<select id="criteria" name="criteria">
					<option value="customer_receipt.id">รหัสใบรายการ</option>
					<option value="customer.name">ชื่อ</option>
					<option value="customer.nickname">ชื่อเล่น</option>
				</select>
				<label for="keyword" class="inline">คำค้น : </label>
				<input type="text" id="keyword" name="keyword" />
				<input type="submit" name="submit" value="ค้นหา" />
			</form>
		</div>
		<hr />
		<table width="100%" border="1" align="center" cellpadding="5" cellspacing="0">
			<tr>
				<th scope="col">รหัสใบรายการ</th>
				<th scope="col">ลูกค้า</th>
                <th scope="col">ประเภทผ้า</th>
                <th scope="col">ประเภทงาน</th>
                <th scope="col">จำนวนผ้า<br />(ชิ้น)</th>
                <th scope="col">จำนวนเงิน<br />(บาท)</th>
				<th scope="col">วันที่นัดรับผ้า</th>
                <th scope="col">การรับผ้า</th>
				<th scope="col">การดำเนินการ</th>
			</tr>
             <?php
			require_once('../include/connect.php');
			$sql = 'SELECT 
						customer_receipt.*,
						customer.name,
						customer.lastname,
						customer.nickname,
						order_head.id,
						order_head.is_receive,
						order_head.id_order_status AS "order_status_id",
						customer_receipt_type.name AS "receipt_type",
						product_group.name AS "group_name",
						order_head.date_due AS "date_due",
						order_head.total_item AS "total_item",
						order_type.name AS "order_type"
						
					
						
					FROM order_head
					
					LEFT JOIN customer_receipt
					ON customer_receipt.id_order = order_head.id
					
					LEFT JOIN product_group
					ON order_head.id_product_group = product_group.id
					
					LEFT JOIN order_type
					ON order_head.id_order_type = order_type.id
				  
					LEFT JOIN customer
					ON customer_receipt.id_customer = customer.id
					 
					LEFT JOIN customer_receipt_type
					ON customer_receipt.id_receipt_type = customer_receipt_type.id
					
					ORDER BY order_head.id DESC ';
	
					
			$query = mysql_query($sql) or die(mysql_error());
			$query_rows = mysql_num_rows($query);
			
			if($query_rows > 0)
			{
				while($data = mysql_fetch_array($query))
				{	
					
					$is_receive = ($data['is_receive']) ? '<span class="green bold">รับผ้าแล้ว</span>' : '<a href="order_read.php?id='.$data['id'].'" target="_blank">
					<span class="red bold">รอรับผ้า</span></a>';	
					
					//
					if($data['order_status_id'] == 1)
					{
						$button = '<a><span class="gray">ผ้ายังไม่เสร็จ</span></a>';
					}
					if($data['order_status_id'] == 2)
					{
						$button = '<a href="receive1.php?id='.$data['id'].'" target="_blank" ><span class="gray bold">ยืนยันการรับผ้า</span></a>';
					}
					if($data['is_receive'] == 1)
					{
						$button = '<a><span class="gray">เสร็จ</span></a>';
					}
					if($data['group_name'] == "")	
					{
						$data['group_name'] = "-";
					}
					
					if($data['order_type'] == "")	
					{
						$data['order_type'] = "-";
					}	
									
					echo '<tr>
							  <td class="center">'.zero_fill(6, $data['id']).'</td>
							  <td>'.$data['name'].' '.$data['lastname'].' ('.$data['nickname'].')</td>
							  <td class="center">'.$data['group_name'].'</td>
							  <td class="center">'.$data['order_type'].'</td>
							  <td class="right">'.$data['total_item'].'</td>
							  <td class="right">'.add_comma($data['amount']).'</td>
							  <td class="center">'.change_date_time_format($data['date_due']).'</td>
							  <td class="center">'.$is_receive.'</td>
							  <td class="center">'.$button.'</td>
						 </tr>';
				}
			}
			else
			{
				echo '<tr><td align="center" colspan="9">No result found.</td></tr>';	
			}
			?>
		</table>
		<div style="clear:both"></div>
	</div>
	<?php include("inc.footer.php"); ?>
</div>
</body>
</html>
