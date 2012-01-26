<?php 
require("../include/session.php");
require('../include/connect.php');

$sql 	= 'SELECT 
			  customer_receipt.*,
			  customer.name,
			  customer.lastname,
			  customer.nickname,
			  customer.tel,
			  customer.date_start,
			  customer.date_exp,
			  customer.address
			   
		   FROM customer_receipt
		   
		   LEFT JOIN customer
		   ON customer_receipt.id_customer = customer.id
		   
		   WHERE customer_receipt.id = "'.$_GET['id'].'"';
		   
$query	= mysql_query($sql) or die(mysql_error());
$data	= mysql_fetch_array($query);

list($create_date, $create_time) = explode(' ', $data['date_create']);

$create_time = substr($create_time, -8, 5);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ใบเสร็จรับเงินค่าสมาชิกรายเดือน</title>
<?php include("inc.css.php"); ?>

<style type="text/css" media="print">
#paper
{
	width: 21cm;
	min-height: 25cm;
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

#signature
{
	bottom: 181px;
	margin: 50px;
	padding: 50px;
	position: absolute;
	right: 3px;
	text-align: center;
}
</style>
</head>

<body>
<div id="paper">
	<table width="100%">
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2"><h1 align="center">ใบเสร็จรับเงินค่าสมาชิกรายเดือน</h1></td>
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
			<td>ประเภท <u>ลูกค้ารายเดือน</u></td>
			<td align="right">เลขที่ใบเสร็จรับเงิน <?php echo zero_fill(6, $data['id']); ?></td>
		</tr>
		<tr>
			<td>รหัสสมาชิก : <?php echo zero_fill(4, $data['id_customer']); ?></td>
			<td width="33%" align="right">วันที่ : <?php echo change_date_format($create_date); ?> เวลา <?php echo $create_time; ?> น.</td>
		</tr>
		<tr>
			<td>ชื่อ : <?php echo $data['name'].' '.$data['lastname'] ?></td>
			<td width="33%" align="right">&nbsp;</td>
		</tr>
		<tr>
			<td>ที่อยู่ : <?php echo $data['address']; ?></td>
			<td align="right">วันเริ่มต้น : <?php echo $data['date_start'] ?></td>
		</tr>
        <tr>
        	<td>โทร <?php echo $data['tel'] ?></td>
          <td align="right">วันหมดอายุ : <?php echo $data['date_exp'] ?></td>
        </tr>
	</table>
	<table width="100%" class="border">
<tr>
			<td width="30" align="center">ลำดับ </td>
			<td align="center">รายการ </td>
			<td width="200" align="center">จำนวน ( บาท )</td>
		</tr>
		<tr>
			<td align="center">1</td>
			<td>ค่าสมาชิกรายเดือน ซักอบรีด 50 ชิ้น </td>
			<td align="right">500</td>
		</tr>
		<tr>
			<td colspan="2" align="right">จำนวนเงิน</td>
			<td align="right">500</td>
		</tr>
		<tr>
			<td colspan="2" align="right">รวมราคาทั้งสิน</td>
			<td align="center">ห้าร้อยบาท</td>
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
    		<td  align="center">ผู้รับเงิน   </td>
    	</tr>
      </table>   
	
</div>
</body>
</html>