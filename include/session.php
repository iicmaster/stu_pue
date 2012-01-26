<?php 
session_start();
		
if( ! isset($_SESSION["login"]))
{	
	// Report
	$css		= '../css/style.css';
	$url_target	= 'login.php';
	$title		= 'lek_laundry';
	$message	= '<li class="red">Login</li>';
	
	require_once("../iic_tools/views/iic_report.php");
	exit();
}
?>