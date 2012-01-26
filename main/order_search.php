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
<title>ใบรายการ</title>
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script type="text/javascript">
$(function(){
	$("a#order").addClass('active');
	
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
		<a href="index.php" class="button float_r">เพิ่มใบรายการ</a>
		<h1>ใบรายการ</h1>
		<hr />
		<div id="search_section">
			<form method="post" action="order_search.php">
				<label for="customer_type" class="inline">ค้นหา : </label>
				<select id="customer_type" name="customer_type">
					<option value="0 OR customer.is_member = 1">ลูกค้าทั้งหมด</option>
					<option value="0">ลูกค้าทั่วไป</option>
					<option value="1">ลูกค้ารายเดือน</option>
				</select>
				<label for="criteria" class="inline">จาก : </label>
				<select id="criteria" name="criteria">
					<option value="order_head.date_due">วันที่นัดรับ</option>
					<option value="customer.name">ชื่อ</option>
					<option value="customer.nickname">ชื่อเล่น</option>
                    <option value="order_head.id">รหัส</option>
				</select>
				<label for="keyword" class="inline">คำค้น : </label>
				<input type="text" id="keyword" name="keyword" value="<?php echo $_POST['keyword']; ?>" />
				<input type="submit" name="submit" value="ค้นหา" />
			</form>
		</div>
		<hr />
		<table width="100%" border="1" align="center" cellpadding="5" cellspacing="0">
			<tr>
				<th scope="col">รหัส</th>
				<th scope="col">ลูกค้า</th>
				<th scope="col">ประเภทผ้า</th>
				<th scope="col">ประเภทงาน</th>
				<th scope="col">จำนวนผ้า<br />(ชิ้น)</th>
				<th scope="col">จำนวนเงิน<br />(บาท)</th>
				<th scope="col">วันที่นัดรับ</th>
				<th scope="col">การรับผ้า</th>
				<th scope="col">สถานะ</th>
				<th scope="col">การดำเนินการ</th>
			</tr>
            <?php
			require_once('../include/connect.php');
			$sql = 'SELECT 
						order_head.*,
						order_type.name AS "order_type",
						customer.name,
						customer.lastname,
						customer.nickname,
						product_group.name as "group_name",
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
						'.$_POST['criteria'].' LIKE "%'.$_POST['keyword'].'%"
						AND
						(customer.is_member = '.$_POST['customer_type'].')
				
					ORDER BY order_head.id ASC';
					
			//echo $sql;
					
			$query = mysql_query($sql) or die(mysql_error());
			$query_rows = mysql_num_rows($query);
			
			if($query_rows > 0)
			{
				while($data = mysql_fetch_array($query))
				{				
					// Change date time format				
					$due_date_time = change_date_time_format($data['date_due']);
					
					$is_receive = ($data['is_receive']) ? 'รับแล้ว' : 'ยังไม่ได้รับ';
					
					echo '<tr>
							  <td class="right">'.zero_fill(6, $data['id']).'</td>
							  <td>'.$data['name'].' '.$data['lastname'].' ('.$data['nickname'].')</td>
							  <td class="center">'.$data['order_type'].'</td>
							  <td class="center">'.$data['group_name'].'</td>
							  <td class="right">'.$data['total_item'].'</td>
							  <td class="right">'.$data['total_price'].'</td>
							  <td class="center">'.$due_date_time.'</td>
							  <td class="center">'.$is_receive.'</td>
							  <td class="center">'.$data['order_status'].'</td>
							  <td class="center">
								  <a href="order_read.php?id='.$data['id'].'">ดู</a> |
								  <a href="order_update.php?id='.$data['id'].'">แก้ไข</a> |
								  <a href="order_delete.php?id='.$data['id'].'">ลบ</a> 
							  </td>
						 </tr>';
				}
			}
			else
			{
				echo '<tr><td align="center" colspan="10">No result found.</td></tr>';	
			}
			?>
		</table>
		<div style="clear:both"></div>
	</div>
	<?php include("inc.footer.php"); ?>
</div>
</body>
</html>
