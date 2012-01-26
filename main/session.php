<?php 

session_start();
if(! isset($_SESSION['is_login']))
{
	header ('Content-type: text/html; charset=utf-8');
	echo 'กรุณา Login ก่อนค่ะ';
	echo '<hr />';
	echo '<a href="login.php">Login</a>';	
	exit();
}

?>