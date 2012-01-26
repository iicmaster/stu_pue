<?php 
/* -------------------------------------------------------------------------------- */
/* Include */
/* -------------------------------------------------------------------------------- */

require_once("../include/session.php"); 
require_once("../include/connect.php");

/* -------------------------------------------------------------------------------- */
/* Setup pagination */
/* -------------------------------------------------------------------------------- */

// Check page
$_GET['page'] = (isset($_GET['page'])) ? $_GET['page'] : 1;

// Get total rows
$sql = 'SELECT * FROM customer';
$query = mysql_query($sql); 
$total_rows = mysql_num_rows($query);

// Set date to display per page
$rows_per_page = 10;

// Set start query from					
$limit_start = ($_GET['page'] - 1) * $rows_per_page;

// Set pagination link target
$target = 'customer.php?page=';

/* -------------------------------------------------------------------------------- */
/* End */
/* -------------------------------------------------------------------------------- */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>รายชื่อลูกค้า</title>
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script type="text/javascript">
$(function(){
	$("#menu #customer").addClass('active');
});
</script>
<?php include('inc.css.php'); ?>
</head>

<body>
<div id="container">
	<?php include('inc.header.php'); ?>
	<div id="content"> 
		<a href="customer_create.php" class="button float_r">เพิ่มลูกค้าใหม่</a>
		<h1>รายชื่อลูกค้า</h1>
		<hr />
		<div id="search_section">
			<form method="post" action="customer_search.php">
				<label for="customer_type" class="inline">ค้นหา : </label>
				<select id="customer_type" name="customer_type">
					<option value="0 OR customer.is_member = 1">ลูกค้าทั้งหมด</option>
					<option value="0">ลูกค้าทั่วไป</option>
					<option value="1">ลูกค้ารายเดือน</option>
				</select>
				<label for="criteria" class="inline">จาก : </label>
				<select id="criteria" name="criteria">
					<option value="name">ชื่อ</option>
					<option value="nickname">ชื่อเล่น</option>
					<option value="id">รหัส</option>
				</select>
				<label for="keyword" class="inline">คำค้น : </label>
				<input type="text" id="keyword" name="keyword" value="<?php if(isset($_POST['keyword'])) echo $_POST['keyword']; ?>" />
				<input type="submit" name="submit" value="ค้นหา" />
			</form>
		</div>
		<hr />
		<table width="100%" border="1" align="center" cellpadding="5" cellspacing="0">
			<tr>
				<th scope="col">รหัส</th>
				<th scope="col">ชื่อ - นามสกุล</th>
				<th scope="col">ที่อยู่</th>
				<th scope="col">เบอร์โทรศัพท์</th>
				<th scope="col">วันที่สมัคร/วันที่ต่ออายุ</th>
				<th scope="col">วันหมดอายุ</th>
				<th scope="col">สถานะ</th>
				<th scope="col">แก้ไข</th>
			</tr>
			<?php 
				 include_once('../include/connect.php');
				 
				 $sql = 'SELECT * FROM customer ORDER BY id DESC LIMIT '.$limit_start.', '.$rows_per_page;  
				 $result = mysql_query($sql);
				 $result_row = mysql_num_rows($result);
				 
				 if($result_row > 0)
				 {
					 while($data = mysql_fetch_array($result))
					 {
						// check customer status
						if($data['is_member'] == 1)
						{
							if($data['date_exp'] < date('Y-m-d'))
							{
								$customer_type = '<span class="red">หมดอายุ</span>';
								$amount = 0;
							}
							else
							{
								$customer_type = '<span class="bold green">ลูกค้ารายเดือน</span>';
								$amount = $data['credit'];
							}
							
							$date_exp = $thai_date->convert_date($data['date_exp'].' 00:00:00', 'G3');
						}
						else
						{
							$customer_type = 'ลูกค้าทั่วไป';
							$amount = '-';
							$date_exp = '-';
						}
						
						if($data['is_member'] == 1)
						{
							$receipt = '<a href="customer_print_receipt.php" class="button float_r">พิมพ์ใบเสร็จรับเงิน</a> | ';	
						}
						else
						{
							$receipt = '';
						}
						 
						echo '<tr>';
						echo '<td class="center">'.zero_fill(4, $data['id']).'</td>';
						echo '<td class="nowarp">'.$data['name'].' '.$data['lastname'].'</td>';
						echo '<td>'.$data['address'].'</td>';
						echo '<td class="nowarp">'.$data['tel'].'</td>';
						echo '<td align="center" class="nowarp">'.$thai_date->convert_date($data['date_register'].' 00:00:00', 'G3').'</td>';
						echo '<td align="center" class="nowarp">'.$date_exp.'</td>';
						echo '<td align="center" class="nowarp">'.$customer_type.'</td>';
						echo '<td align="center" class="nowarp">
								<a href="customer_update.php?id='.$data['id'].'">แก้ไข</a> |
								<a href="customer_delete.php?id='.$data['id'].'">ลบ</a> 
							  </td>';
						echo '</tr>';
					 }
				 }
				 else
				 {
					 echo '<tr><td colspan="9">No result found.</td></tr>';
				 }
			 
			?>
		</table>
		<div class="pagination">
			<?php echo get_pagination($total_rows, $target, $_GET['page'], $rows_per_page); ?>
		</div>
		<div style="clear:both"></div>
	</div>
	<?php include("inc.footer.php"); ?>
</div>
</body>
</html>
