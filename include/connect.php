<?php
/*--------------------------------------------------------------------------------*/
/* Connection */
/*--------------------------------------------------------------------------------*/

// Set connection variable
$HOST		= "localhost";
$USERNAME	= "root";
$PASSWORD	= "";
$DATABASE	= "lek_laundry";

// Open connection
$link = mysql_connect($HOST, $USERNAME, $PASSWORD);

// Select data base
mysql_select_db($DATABASE); 

// Set mysql chracter set
mysql_query("SET NAMES UTF8");

/*--------------------------------------------------------------------------------*/
/* Date time setting */
/*--------------------------------------------------------------------------------*/

date_default_timezone_set("Asia/Bangkok");

/*--------------------------------------------------------------------------------*/
/* Include */
/*--------------------------------------------------------------------------------*/

include('thaidate.php');
include('../iic_tools/helpers/iic_utilities_helper.php');
include('../iic_tools/helpers/iic_crud_helper.php');

$thai_date = new Thaidate;

/*--------------------------------------------------------------------------------*/
/* End */
/*--------------------------------------------------------------------------------*/
?>