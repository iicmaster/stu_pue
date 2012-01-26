<?php 
require("../include/session.php");
require('../include/connect.php');

$sql 	= 'SELECT ';
		   
//echo $sql;
		   
$query	= mysql_query($sql) or die(mysql_error());
$data	= mysql_fetch_assoc($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>รายงานการเคลื่อนไหววัตถุดิบ</title>
<?php include("inc.css.php"); ?>
<style type="text/css" media="print">
#paper {
	width: 16cm;
	min-height: 24.7cm;
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
#paper h3 {
	margin-bottom: 0px;
}
#paper li {
	list-style: decimal;
	margin: 5px 0px 5px 30px;
}
#paper textarea {
	margin-bottom:25px;
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
</style>
</head>

<body>
<div id="paper">
  <table width="100%">
    <tr>
      <td width="80" align="right">วันที่ <?php echo change_date_format(date('Y-m-d')); ?></td>
    </tr>
    <tr>
      <td><h1 align="center">รายงานการเคลื่อนไหววัตถุดิบ</h1></td>
    </tr>
    <tr>
      <td align="center"><h5>ช่วงวันที่ &nbsp;&nbsp;<?php echo change_date_format($_POST['date_start']); ?> &nbsp;&nbsp;ถึงวันที่ &nbsp;&nbsp;<?php echo change_date_format($_POST['date_end']); ?></h5></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <thead>
    <tr>
      <td colspan="2"><h3>การเพิ่มวัตุดิบ</h3></td>
      <hr/>
    </tr>
  </thead>
  <table width="100%" class="border">
    <tbody>
      <tr>
        <td>รหัส</td>
        <td>วัตถุดิบ</td>
        <td>ยี่ห้อ</td>
        <td>ขนาด</td>
        <td>ราคาต่อ1หน่วย</td>
        <th>เพิ่ม</th>
        <th>หน่วย</th>
        <th>ปรับปรุงข้อมูลล่าสุด</th>
      </tr>
      <tr>
      	<?php 
				include_once('../include/connect.php');
				
				$sql = 'SELECT 
							inventory.*,
							inventory_unit.name AS "unit",
							inventory_transaction.id_inventory,
							inventory_transaction.amount,
							inventory_transaction.description
			
						FROM inventory
						
						LEFT JOIN inventory_unit
						ON inventory.id_inventory_unit = inventory_unit.id
							
						LEFT JOIN inventory_transaction
						ON inventory_transaction.id_inventory = inventory.id';
						
						$query = mysql_query($sql) or die(mysql_error());
		?>
        <td align="right"><?php echo $data['id']; ?></td>
  		<td align="right"><?php echo $data['name']; ?></td>
        <td align="right"><?php echo $data['brand']; ?></td>
  		<td align="right"><?php echo $data['volume']; ?></td>
        <td align="right"><?php echo $data['price']; ?></td>
  		<td align="right"><?php echo $data['member']; ?></td>
        <td align="right"><?php echo $data['unit']; ?></td>
  		<td align="right"><?php echo change_date_time_format($data['date_update']); ?></td>
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