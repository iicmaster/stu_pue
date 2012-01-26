<?php 
require("../include/session.php");
require('../include/connect.php');

$sql 	= 'SELECT DISTINCT
			  (SELECT COUNT(id) FROM customer WHERE is_member = 0 AND date_register BETWEEN "'.$_POST['date_start'].'" AND "'.$_POST['date_end'].'") AS normal,
			  (SELECT COUNT(id) FROM customer WHERE is_member = 1 AND date_start BETWEEN "'.$_POST['date_start'].'" AND "'.$_POST['date_end'].'") AS member
		   FROM customer';
		   
//echo $sql;
		   
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
#paper h3 { margin-bottom: 0px; }
#paper li { list-style: decimal; margin: 5px 0px 5px 30px; }
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
			<td colspan="2" align="right">วันที่ <?php echo change_date_format(date('Y-m-d')); ?></td>
		</tr>
		<tr>
			<td colspan="2"><h1 align="center">รายงานการสมัครใหม่ของลูกค้า</h1></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><h5>ช่วงวันที่ &nbsp;&nbsp;&nbsp;<?php echo change_date_format($_POST['date_start']); ?>  &nbsp;&nbsp;&nbsp;ถึงวันที่ &nbsp;&nbsp;&nbsp;<?php echo change_date_format($_POST['date_end']); ?></h5></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td><h3>ลูกค้าทั่วไป</h3></td>
			<td width="80" align="right"><h3><?php echo $data['normal']; ?> &nbsp;คน</h3></td>
		</tr>
		<tr>
			<td colspan="2"><hr /></td>
		</tr>
		<tr>
			<td>
				<ol>	
				<?php 
				$sql = 'SELECT * 
						
						FROM customer
						 
						WHERE 
							is_member = 0 
							AND 
							date_register BETWEEN "'.$_POST['date_start'].'" AND "'.$_POST['date_end'].'"
							
						ORDER BY date_register';
						
				$query = mysql_query($sql) or die(mysql_error());
				while($row = mysql_fetch_assoc($query))
				{
					echo '<li>[ '.change_date_format($row['date_register']).' ] - '.zero_fill(4,$row['id']).' '.$row['name'].' '.$row['lastname'].' ('.$row['nickname'].')</li>';
				}
				?>
				</ol>
			</td>
			<td></td>
		</tr>

		<tr>
			<td><h3>ลูกค้ารายเดือน</h3></td>
			<td align="right"><h3><?php echo $data['member']; ?> &nbsp;คน</h3></td>	
		</tr>
		<tr>
			<td colspan="2"><hr /></td>
		</tr>
		<tr>
			<td>
				<ol>	
				<?php 
				$sql = 'SELECT * 
						
						FROM customer
						 
						WHERE 
							is_member = 1
							AND 
							date_start BETWEEN "'.$_POST['date_start'].'" AND "'.$_POST['date_end'].'"
							
						ORDER BY date_start';
						
				$query = mysql_query($sql) or die(mysql_error());
				while($row = mysql_fetch_assoc($query))
				{
					echo '<li>[ '.change_date_format($row['date_start']).' ] - '.zero_fill(4,$row['id']).' '.$row['name'].' '.$row['lastname'].' ('.$row['nickname'].')</li>';
				}
				?>
				</ol>
			</td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2" align="right"><hr /></td>
		</tr>
		<tr>
			<td align="right"><h3>รวม</h3></td>
			<td align="right"><h3><?php echo ($data['normal'] + $data['member']); ?> &nbsp;คน</h3></td>
		</tr>
	</table>
</div>
</body>
</html>