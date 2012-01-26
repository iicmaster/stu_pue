<?php require_once("../include/session.php"); ?>
<?php
require_once("../include/connect.php");

$sql	= 'SELECT * FROM machine WHERE id = '.$_GET['id'];
$query	= mysql_query($sql) or die(mysql_error());
$data	= mysql_fetch_array($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>แก้ไขข้ออุปกรณ์</title>
<?php include('inc.css.php'); ?>
</head>
<body>
<div id="container">
	<?php include('inc.header.php'); ?>
	<div id="content">
		<h1>แก้ไขข้ออุปกรณ์</h1>
		<hr />
		<form method="post" action="">
			<label for="id_machine_type">ประเภทอุปกรณ์:</label>
			<select id="id_machine_type" name="id_machine_type" disabled="disabled">
				<option value="1" <?php if($data['id_machine_type'] == 1) echo 'selected="selected"'; ?>>เครื่องซักผ้า</option>
				<option value="2" <?php if($data['id_machine_type'] == 2) echo 'selected="selected"'; ?>>เครื่องอบผ้า</option>
				<option value="3" <?php if($data['id_machine_type'] == 3) echo 'selected="selected"'; ?>>เตารีด</option>
			</select>
			<label for="id_machine_size">ขนาด : </label>
			<select id="id_machine_size" name="id_machine_size" disabled="disabled">
				<option value="1" <?php if($data['id_machine_size'] == '1') echo 'selected="selected"'; ?>>เล็ก</option>
				<option value="2" <?php if($data['id_machine_size'] == '2') echo 'selected="selected"'; ?>>กลาง</option>
				<option value="3" <?php if($data['id_machine_size'] == '3') echo 'selected="selected"'; ?>>ใหญ่</option>
			</select>
			<label for="name">ชื่อยี่ห้อ:</label>
			<input id="name" name="name" type="text" value="<?php echo $data['name'] ?>" readonly="readonly" />
			<label for="model">ชื่อรุ่น:</label>
			<input id="model" name="model" type="text" value="<?php echo $data['model'] ?>" readonly="readonly" />
			<label for="description">คำอธิบาย:</label>
			<textarea id="description" name="description" readonly="readonly"><?php echo $data['description'] ?></textarea>
			<label>
			สถานะ:
			<label for="enable" class="normal">
				<input id="enable" name="is_enable" type="radio" value="1" <?php if($data['is_enable'] == 1) echo 'checked="checked"'; ?> disabled="disabled" />
				เปิดใช้งาน </label>
			<label for="disable" class="normal">
				<input id="disable" name="is_enable" type="radio" value="0" <?php if($data['is_enable'] == 0) echo 'checked="checked"'; ?> disabled="disabled" />
				ไม่ใช้งาน</label>
			</label>
			<hr />
			<a href="machine.php">กลับ</a>
		</form>
	</div>
	<?php include("inc.footer.php"); ?>
</div>
</body>
</html>