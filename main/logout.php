<?php
session_start();
session_destroy();

// Report
$css		= '../css/style.css';
$url_target	= 'login.php';
$title		= 'lek_laundry';
$message	= '<li class="green">Logout</li>';

require_once("../iic_tools/views/iic_report.php");
exit();
?>