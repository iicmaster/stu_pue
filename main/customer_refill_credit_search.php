<?php 
require_once("../include/session.php"); 
include_once('../include/connect.php');

$_POST['keyword'] = (isset($_POST['keyword'])) ? $_POST['keyword'] : '';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ต่อายุสมาชิก</title>
<?php include('inc.css.php'); ?>
<style type="text/css">
#search_section
{
	margin: -10px 0px 10px 0px;
}
#search_section input[type=text], #search_section select { min-width: 150px; margin-right: 15px; }
#search_section input[type=submit] { margin: 0px; }
</style>
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script type="text/javascript">
$(function(){
	//Change color
	$("#menu a#customer").addClass('active');
	
	$("#category").val('<?php echo (isset($_POST['category'])) ? $_POST['category'] : 'name' ?>');
});
</script>
</head>

<body>
<div id="container">
	<?php include("inc.header.php"); ?>
	<div id="content">
		<h1>ต่อายุสมาชิก</h1>
		<hr />
		<div id="search_section">
			<form method="post" action="customer_refill_credit_search.php">
				<label for="category" class="inline">ค้นหาจาก : </label>
				<select id="category" name="category">
					<option value="name">ชื่อ</option>
					<option value="nickname">ชื่อเล่น</option>
					<option value="id">รหัส</option>
				</select>
				<label for="keyword" class="inline">คำค้น : </label>
				<input type="text" id="keyword" name="keyword" value="<?php echo $_POST['keyword'] ?>" />
				<input type="submit" name="submit" value="ค้นหา" />
			</form>
		</div>
		<hr />
		<table width="100%" border="1" cellpadding="5" cellspacing="0">
			<thead>
				<tr>
					<th>รหัส</th>
					<th>ชื่อ - นามสกุล</th>
					<th>ชื่อเล่น</th>
					<th>ประเภท</th>
					<th>จำนวนผ้าคงเหลือ</th>
					<th><?php if(isset($_POST['customer_type'])){ echo ($_POST['customer_type'] == 1) ? 'วันที่สมัคร / ต่ออายุ' : 'วันที่สมัคร'; } else { echo 'วันที่สมัคร'; }?></th>
					<th>วันหมดอายุ</th> 
					<th>การดำเนินการ</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			 
			// Get search result
			if(isset($_POST['submit']))
			{
				
				$sql = 'SELECT * 
				
						FROM customer 
						
						WHERE 
							is_member = "1"	
							AND 
							'.$_POST['category'].' LIKE "%'.$_POST['keyword'].'%"'; 	
									
				$query = mysql_query($sql); 
				$query_rows = mysql_num_rows($query);
				 
				if($query_rows > 0)
				{
					while($data = mysql_fetch_array($query))
					{
						$button = '<a href="customer_refill_credit.php?id='.$data['id'].'" class="button bold" style="color:#F00;">ต่ออายุ</a>';
						
						// Check customer status
						if($data['is_member'] == 1)
						{
							if(get_timestamp($data['date_exp']) < get_timestamp(date('Y-m-d')))
							{
								$customer_type = '<span class="red">หมดอายุ</span>';
								$credit = '-';
							}
							else
							{
								$customer_type = '<span class="green">ลูกค้ารายเดือน</span>';
								
								if($data['credit'] < 10)
								{
									$credit = '<span class="bold red">'.$data['credit'].'</span>';
								}
								else
								{
									$credit = $data['credit'];
								}
							}
							
							$date_start = change_date_format($data['date_start']);
							$date_exp = change_date_format($data['date_exp']);
						}
						else
						{
							$date_start = change_date_format($data['date_register']);
							$customer_type = 'ลูกค้าทั่วไป';
							$credit = '-';
							$date_exp = '-';
						}
						
						echo '<tr>
								<td class="center">'.zero_fill(4, $data['id']).'</td>
								<td>'.$data['name'].' '.$data['lastname'].'</td>
								<td>'.$data['nickname'].'</td>
								<td align="center">'.$customer_type.'</td>
								<td align="center">'.$credit.'</td>
								<td align="center">'.$date_start.'</td>
								<td align="center">'.$date_exp.'</td>
								<td class="center">'.$button.'</td>
							  </tr>';
					}
				}
				else
				{
					echo '<tr><td colspan="8" class="center">ไม่มีข้อมูล</td></tr>';
				} 
			}
			else
			{
				echo '<tr><td colspan="8" class="center">&nbsp;</td></tr>';
			} 
			?>
			</tbody>
		</table>
	</div>
	<?php include("inc.footer.php"); ?>
</div>
</body>
</html>
