<?php 
require("../include/session.php");
require('../include/connect.php');

$sql 	= 'SELECT 
			  customer_receipt.*,
			  customer.name,
			  customer.lastname,
			  customer.nickname,
			  customer.tel,
			  customer.address,
			  customer.is_member,
			  customer.credit,
			  order_head.total_price,
			  order_head.total_item,
			  order_head.id_product_group,
			  order_head.id_order_type,
			  order_head.date_due,
			  order_head.id AS "order_id",
			  order_type.name AS "order_type",
			  product_group.name AS "group_name"
		   
		   FROM customer_receipt
		   
		   LEFT JOIN customer
		   ON customer_receipt.id_customer = customer.id
		   
		   LEFT JOIN order_head
		   ON customer_receipt.id_order = order_head.id
					  
		   LEFT JOIN order_type
		   ON order_head.id_order_type = order_type.id
	 
		   LEFT JOIN product_group
		   ON order_head.id_product_group = product_group.id
		   
		   WHERE customer_receipt.id = "'.$_GET['id'].'"';
		   
$query	= mysql_query($sql) or die(mysql_error());
$data	= mysql_fetch_array($query);

list($create_date, $create_time) = explode(' ', $data['date_create']);

$create_time = substr($create_time, -8, 5);

list($due_date, $due_time) = explode(' ', $data['date_due']);

$due_time = substr($due_time, -8, 5);


$customer_type = ($data['is_member'] == 1) ? 'รายเดือน' : 'ลูกค้าทั่วไป'; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ใบเสร็จรับเงิน</title>
<?php include("inc.css.php"); ?>
<style type="text/css" media="print">
#paper {
	width: 21cm;
	min-height: 25cm;
	padding: 2.5cm;
	position: relative;
}
</style>
<style type="text/css" media="screen">
#paper {
	background: #FFF;
	border: 1px solid #666;
	margin: 20px auto;
	width: 21cm;
	min-height: 25cm;
	padding: 50px;
	position: relative;
	/* CSS3 */
	
	box-shadow: 0px 0px 5px #000;
	-moz-box-shadow: 0px 0px 5px #000;
	-webkit-box-shadow: 0px 0px 5px #000;
}
</style>
<style type="text/css" >
#paper textarea {
	margin-bottom: 25px;
	width: 50%;
}
#paper table, #paper th, #paper td {
	border: none;
}
#paper table.border, #paper table.border th, #paper table.border td {
	border: 1px solid #666;
}
#paper th {
	background: none;
	color: #000
}
#paper hr {
	border-style: solid;
}
#signature {
	bottom: -35px;
	margin: 50px;
	padding: 50px;
	position: absolute;
	right: 2px;
	text-align: center;
}
body, td, th {
	color: #333;
}
</style>
</head>

<body>
<div id="paper">
  <table width="100%">
    <tr>
      <td colspan="2"><h1 align="center">ใบเสร็จรับเงิน</h1></td>
    </tr>
    <tr>
      <td colspan="2" align="center">ร้านคุณเล็กซักอบรีด</td>
    </tr>
    <tr>
      <td colspan="2" align="center">227 ตลาดศรีทองคำ ดินแดง กรุงเทฯ 10400</td>
    </tr>
    <tr>
      <td colspan="2" align="center">โทร 02-6433873</td>
    </tr>
    <tr>
      <td width="64%">ประเภท <u><?php echo $customer_type; ?></u></td>
      <td width="36%" align="right">เลขที่ใบเสร็จรับเงิน : <?php echo zero_fill(6, $data['id']); ?></td>
    </tr>
    <tr>
      <td>รหัสสมาชิก : <?php echo zero_fill(4, $data['id_customer']); ?></td>
      <td align="right">เลขที่ใบรายการ : <?php echo zero_fill(6, $data['order_id']); ?></td>
    </tr>
    <tr>
      <td>ชื่อ : <?php echo $data['name'].' '.$data['lastname'] ?></td>
      <td align="right">ประเภทผ้า : <?php echo $data['group_name'] ?></td>
    </tr>
    <tr>
      <td align="left">ที่อยู่ : <?php echo $data['address']; ?></td>
      <td align="right">ประเภทงาน : <?php echo $data['order_type'] ?></td>
    </tr>
    <tr>
      <td align="left">โทร : <?php echo $data['tel'] ?></td>
      <td align="right">วันที่ทำรายการ : <?php echo $thai_date->convert_date($create_date.' 00:00:00', 'G3'); ?> เวลา : <?php echo $create_time; ?> น.</td>
    </tr>
    <tr>
      <td  <?php if($data['is_member'] == 1): ?>align="left">เครดิตคงเหลือ : <?php echo $data['credit']; ?>
        <?php endif; ?></td>
      <td align="right">วันที่นัดรับของ : <?php echo $thai_date->convert_date($due_date.' 00:00:00', 'G3'); ?> เวลา : <?php echo $due_time; ?> น.</td>
    </tr>
  </table>
  <table width="100%" class="border">
    <tr>
      <th width="30" align="center">ลำดับ </th>
      <th align="center">รายการ </th>
      <?php if($data['is_member'] == 0 || $data['id_product_group'] != 1): ?>
      <th width="100" align="center">ค่าบริการต่อชื้น<br />
        (บาท)</th>
      <?php endif; ?>
      <th width="100" align="center">จำนวนผ้า<br />
        (ชิ้น)</th>
      <?php if($data['is_member'] == 0 || $data['id_product_group'] != 1): ?>
      <th width="100" align="center">รวมเป็นเงิน<br />
        (บาท)</th>
      <?php endif; ?>
    </tr>
    <?php 
	$sql_item = 'SELECT 
						order_item.*,
						product.name AS item_name, 
						product.price_wash,
						product.price_iron,
						product.id_product_group
						
				 FROM order_item
				 
				 LEFT JOIN product
				 ON order_item.id_product = product.id
				 
				 WHERE order_item.id_order = "'.$data['id_order'].'"';
				 
	//echo $sql;
	//exit();
					 
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
		switch($data['id_order_type'])
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
      <td align="center"><?php echo $loop; ?></td>
      <td><?php echo $product_name; ?></td>
      <?php if($data['is_member'] == 0 || $data['id_product_group'] != 1): ?>
      <td align="right"><?php echo $product_price; ?></td>
      <?php endif; ?>
      <td align="right"><?php echo $data_item['quantity']; ?></td>
      <?php if($data['is_member'] == 0 || $data['id_product_group'] != 1): ?>
      <td align="right"><?php echo ($product_price * $data_item['quantity']); ?></td>
      <?php endif; ?>
    </tr>
    <?php $loop++; ?>
    <?php endwhile; ?>
    <tr>
      <td colspan="<?php if($data['is_member'] == 0 || $data['id_product_group'] != 1){ echo '3'; } else { echo '2'; } ?>" align="right">รวม</td>
      <td align="right"><?php echo $data['total_item']; ?></td>
      <?php if($data['is_member'] == 0 || $data['id_product_group'] != 1): ?>
      <td align="right"><?php echo add_comma($data['total_price'], 2); ?></td>
      <?php endif; ?>
    </tr>
  </table>
  <table width="30%" align="right" >
    <tr >
      <td  align="center">................................</td>
    </tr>
    <tr >
      <td   align="center">( ศิริยา ชัยรัตนสุนทร ) </td>
    </tr>
    <tr >
      <td  align="center">ผู้รับเงิน </td>
    </tr>
  </table>
</div>
</body>
</html>