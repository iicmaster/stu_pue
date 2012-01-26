<?php require_once("../include/session.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>อุปกรณ์</title>
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script type="text/javascript">
$(function(){
	$("#menu a#machine").addClass('active');
});
</script>
<?php include('inc.css.php'); ?>
<style type="text/css">
body,td,th { font-family: "Microsoft Sans Serif", "Helvetica Neue", Arial, "Liberation Sans", FreeSans, sans-serif; }
</style>
</head>

<body>
<div id="container">
	<?php include('inc.header.php'); ?>
	<div id="content"> 
		<a href="machine_create.php" class="button float_r">เพิ่ม</a>
		<h1>อุปกรณ์</h1>
		<hr />
		<table width="100%" border="1" align="center" cellpadding="5" cellspacing="0">
			<tr>
				<th scope="col">รหัส</th>
				<th scope="col">ประเภท</th>
				<th scope="col">ชื่อยี่ห้อ</th>
				<th scope="col">ชื่อรุ่น</th>
				<th scope="col">ขนาด</th>
				<th scope="col">สถานะ</th>
				<th scope="col">แก้ไข</th>
			</tr>
			<?php 
				 include_once('../include/connect.php');
				 
				 $sql = 'SELECT 
				 			machine.* ,
							machine_type.name AS "type",
							machine_size.name AS "size"
				 
				 		 FROM machine
						 
						 LEFT JOIN machine_type
						 ON machine.id_machine_type = machine_type.id
						 
						 LEFT JOIN machine_size
						 ON machine.id_machine_size = machine_size.id';
						 
				 $result = mysql_query($sql) or die(mysql_error());
				 $result_row = mysql_num_rows($result);
				 
				 if($result_row > 0)
				 {
					 while($data = mysql_fetch_array($result))
					 {
						// check status
						$machine_status = ($data['is_enable'] == 1) ? '<span class="green">เปิดใช้งาน</span>' : '<span class="red">ไม่ใช้งาน</span>';
												 
						echo '	<tr>
									<td class="center">'.$data['id'].'</td>
									<td>'.$data['type'].'</td>
									<td>'.$data['name'].'</td>
									<td><a href="machine_read.php?id='.$data['id'].'">'.$data['model'].'</a> </td>
									<td class="center">'.$data['size'].'</td>
									<td class="center">'.$machine_status.'</td>
									<td class="center">
										<a href="machine_update.php?id='.$data['id'].'">แก้ไข</a> |
										<a href="machine_delete.php?id='.$data['id'].'">ลบ</a> 
									</td>
								</tr>';
					 }
				 }
				 else
				 {
					 echo '<tr><td colspan="6" class="center">No result found.</td></tr>';
				 }
			 
			?>
		</table>
	</div>
	<?php include("inc.footer.php"); ?>
</div>
</body>
</html>
