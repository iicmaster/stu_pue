<?php require_once("../include/session.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ใบรายการ</title>
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script type="text/javascript">
$(function(){
	$("#menu a:eq(2)").addClass('active');
});
</script>
<?php include('inc.css.php'); ?>
<style type="text/css">
a.float_r { margin-left: 20px; }

#order_head { font-size: 14px; }

#order_head table, #order_head td { border: none; }

#order_head ul li { margin: 10px 0px; }

#order_process
{
	float: right;
	min-width: 150px;
}

#order_process ul
{
	list-style-position: inside;
	margin-top: 5px;
}

#order_process ul li
{
	list-style-type: circle;
	margin: 2px 0px;
	padding: 2px 10px;
}

#order_process > ul > li.complete + li, #order_process > ul > li:first-child { list-style-type: disc; }

#order_process > ul > li.complete
{
	list-style-type: disc;
	text-decoration: line-through;
}
</style>
</head>

<body>
<div id="container">
	<?php include('inc.header.php'); ?>
	<div id="content">
		<h1>ใบรายการ</h1>
		<hr />
		<div id="order_head">
			<?php
			include('../include/connect.php');
			
			$sql = 'SELECT 
						order_head.*,
						order_type.name AS "order_type",
						product_group.name AS "group_name", 
						product_group.id AS "group_id",
						customer.name,
						customer.lastname,
						customer.nickname,
						customer.is_member,
						customer.credit,
						order_status.name AS "order_status"
							
					FROM order_head
				  
					LEFT JOIN order_type
					ON order_head.id_order_type = order_type.id
				 
					LEFT JOIN product_group
					ON order_head.id_product_group = product_group.id
				  
					LEFT JOIN customer
					ON order_head.id_customer = customer.id
				  
					LEFT JOIN order_status
					ON order_head.id_order_status = order_status.id
				  
					WHERE 
						order_head.id = "'.$_GET['id'].'"';
						
			$query	= mysql_query($sql) or die(mysql_error());
			$data	= mysql_fetch_array($query);
			
			list($create_date, $create_time) = explode(' ', $data['date_create']);
			
			$create_time = substr($create_time, -8, 5);
			
			list($due_date, $due_time) = explode(' ', $data['date_due']);
			
			$due_time = substr($due_time, -8, 5);
			
			$id_order_type = $data['id_order_type'];
			$total_item = $data['total_item'];
			$total_price = ($data['is_member'] == 1 && $data['id_product_group'] == 1) ? 0 : $data['total_price'];
			
			$customer_type = ($data['is_member'] == 1) ? 'ลูกค้ารายเดือน' : 'ลูกค้าทั่วไป'; 
			?>
			<table width="100%">
				<tr>
					<td width="503">
                    	<ul>
							<li><strong>ประเภท : </strong><u><?php echo $customer_type; ?></u></li>
							<li><strong>รหัสลูกค้า : </strong><?php echo zero_fill(4, $data['id_customer']); ?></li>
							<li><strong>ชื่อ : </strong><?php echo $data['name'].' '.$data['lastname'] ?></li>
							<li><strong>ชื่อเล่น : </strong> <?php echo $data['nickname']; ?></li>
							<li><strong>สถานะ : </strong><?php echo $data['order_status']; ?></li>
							<?php if($data['is_member'] == 1): ?>
							<li><strong>เครดิตคงเหลือ : </strong><?php echo $data['credit']; ?></li>
							<?php endif; ?>
                    	</ul></td>
					<td width="293" align="right">
                    	<ul>
							<li><strong>รหัสใบรายการ : </strong><?php echo zero_fill(6, $data['id']); ?></li>
							<li><strong>ประเภทผ้า : </strong><?php echo $data['group_name']; ?></li>
                            <li><strong>ประเภทงาน : </strong><?php echo $data['order_type']; ?></li>
							<li>
                            	<strong>วันที่ทำรายการ : </strong><?php echo change_date_format($create_date); ?>
                            	<strong> เวลา : </strong><?php echo  $create_time; ?> น.</li>
                           
                            <li>
                            	<strong>วันที่นัดรับของ : </strong><?php echo change_date_format($due_date); ?> 
                            	<strong>เวลา : </strong><?php echo $due_time; ?> น.</li>
						</ul></td>
				</tr>
			</table>
	  </div>
		<table width="100%" border="1" align="center" cellpadding="5" cellspacing="0">
			<tr>
				<th width="30">ลำดับ</th>
				<th>รายการ</th>
				<?php if($data['is_member'] == 0): ?>
				<th width="120">ค่าบริการต่อชิ้น (บาท)</th>
				<?php endif; ?>
				<th width="100">จำนวนผ้า (ชิ้น)</th>
				<?php if($data['is_member'] == 0): ?>
				<th width="100">รวมเป็นเงิน (บาท)</th>
				<?php endif; ?>
			</tr>
			<?php
			$sql_item = 'SELECT 
							order_item.*,
							product.name AS item_name, 
							product.price_wash,
							product.price_iron
							
						 FROM order_item
						 
						 LEFT JOIN product
						 ON order_item.id_product = product.id
						 
						 WHERE order_item.id_order = "'.$_GET['id'].'"';
						 
			$query_item = mysql_query($sql_item);
			
			$loop = 1;
			?>
			<?php while($data_item = mysql_fetch_array($query_item)): ?>
			<?php 
				if($data['id_product_group'] == 3)
				{
					$product_name	= $data_item['product_name'];
					$product_price	= $data_item['product_price'];
				}
				else
				{
					$product_name = $data_item['item_name'];
					
					// Calculate price
					switch($id_order_type)
					{
						case 1:
							$product_price = $data_item['price_wash'] + $data_item['price_iron'];
							break;
						case 2:
							$product_price = $data_item['price_wash'];
							break;
						case 3:
							$product_price = $data_item['price_iron'];
							break;
					}
					
					if($data['is_member'] == 1 && $data['id_product_group'] == 1)
					{
						$product_price = 0;
					}
				}
				?>
			<tr>
				<td class="center"><?php echo $loop; ?></td>
				<td><?php echo $product_name; ?></td>
				<?php if($data['is_member'] == 0): ?>
				<td class="right"><?php echo $product_price; ?></td>
				<?php endif; ?>
				<td class="right"><?php echo $data_item['quantity']; ?></td>
				<?php if($data['is_member'] == 0): ?>
				<td class="right"><?php echo ($product_price * $data_item['quantity']); ?></td>
				<?php endif; ?>
			</tr>
			<?php $loop++;?>
			<?php endwhile; ?>
		</table>
		<hr />
		<div id="order_footer" class="right">
			<h2 id="total_item"><strong>จำนวนผ้ารวม</strong> : <?php echo $total_item; ?> ชิ้น</h2>
            <?php if(!($data['is_member'] ==  1 && $data['group_id'] == 1 )):?>
            	<h2 id="grand_total"><strong>จำนวนเงินรวม</strong> : <?php echo $total_price; ?> บาท</h2>
            <?php endif; ?>
		</div>
		<hr />
		<a href="order.php">กลับ</a> </div>
	<?php include("inc.footer.php"); ?>
</div>
</body>
</html>
