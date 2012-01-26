<?php require_once("../include/session.php"); ?>
<?php include_once('../include/connect.php');?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>คิวรีด</title>
<?php include('inc.css.php'); ?>
<link type="text/css" rel="stylesheet" href="../css/queue.css"  />
<style type="text/css">
div.gadget li { margin: 5px; }
a.black { color: #333; }
</style>
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.11.min.js"></script>
<script type="text/javascript">
$(function(){
	// Set menu to active this page
	$("#menu a#queue").addClass('active');
	
	// Generate queue date caledar
	$("#queue_date").datepicker({dateFormat: 'yy-mm-dd'}).val('<?php echo (isset($_GET['date'])) ? $_GET['date'] : date('Y-m-d') ?>');
	
	$("#queue_date").change(function() 
	{
		var url = 'queue_iron.php?date=' + $(this).val();
		window.open(url, '_self');
	});
});
</script>
</head>

<body>
<div id="container">
	<?php include('inc.header.php'); ?>
	<div id="content">
		<div class="float_r">
			<label for="queue_date">คิวงานประจำวันที่ :
				<input id="queue_date" name="queue_date" type="text" class="center" value="<?php echo date('Y-m-d') ?>" size="10" />
			</label>
		</div>
		<h1>คิวรีด</h1>
		<hr />
		<?php include('queue_menu.php'); ?>
		<hr />
		
		
		<div id="machine">
			<?php 	
			$queue_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
			
			// Get machine				
			$sql = 'SELECT 
						machine.id AS "id_machine",
						machine.*,
						machine_size.name AS "size"
						
					FROM machine 
					
					LEFT JOIN machine_size
					ON machine.id_machine_size = machine_size.id
					
					WHERE 
						machine.id_machine_type	= "3"
						AND 
						machine.is_enable = "1"';
					
			$query = mysql_query($sql) or die(mysql_error());
			
			$total_machine = mysql_num_rows($query);
			
			echo '<table>
					<tr>
						<th scope="col" width="80">คิว \ เครื่อง</th>';
							
			$id_machine = array();
			
			while($data = mysql_fetch_array($query))
			{					
				echo '<th scope="col">'.$data['name'].' ('.$data['size'].')</th>';
				array_push($id_machine, $data['id_machine']);
			}
							
			echo '</tr>';
		
			// Get queue
			
			$sql = 'SELECT * FROM queue_time';
			$query = mysql_query($sql) or die(mysql_error());
			
			$id_queue = 1;
							
			while($data = mysql_fetch_array($query))
			{
				echo '<tr>';
				echo '<th scope="col" valign="middle">'.substr($data['time_start'], 0, 5).' - '.substr($data['time_end'], 0, 5).'
						</th>';
						
				for($loop = 1; $loop <= $total_machine ; $loop++)
				{
					$id_order[$id_machine[($loop - 1)]][0] = '0';
					
					$sql_queue = 'SELECT 
									 queue_iron.id_order,
									 queue_iron.date_start,
									 queue_time.time_start,
									 queue_time.time_end,
									 order_head.total_item,
									 order_head.id_order_type,
									 order_status.name,
									 customer.name AS "customer"
									 
								  FROM queue_iron
								  
								  LEFT JOIN queue_time
								  ON queue_iron.id_queue_time = queue_time.id
								  
								  LEFT JOIN order_head
								  ON queue_iron.id_order = order_head.id
								  
								  LEFT JOIN order_status
								  ON order_head.id_order_status = order_status.id
				  
								  LEFT JOIN customer
								  ON order_head.id_customer = customer.id
								  
								  WHERE 
								 	 queue_iron.id_machine = "'.$id_machine[($loop - 1)].'"
									 AND 
									 queue_iron.id_queue_time = "'.$data['id'].'"
									 AND 
									 DATE(queue_iron.date_start) = "'.$queue_date.'"';
									 
					$query_queue = mysql_query($sql_queue) or die(mysql_error());
					$query_queue_rows = mysql_num_rows($query_queue);
					
					$queue_card = '';
					
					if($query_queue_rows > 0)
					{
						$data_queue = mysql_fetch_array($query_queue);
						
						$id_order[$id_machine[($loop - 1)]][$id_queue] = $data_queue['id_order'];

						if($id_order[$id_machine[($loop - 1)]][$id_queue - 1] != $data_queue['id_order'])
						{
							// Get queue finish time
							$sql = 'SELECT time_end FROM queue_time WHERE id = '.($id_queue + 3);
							$query_queue_finish = mysql_query($sql) or die(mysql_error());
							$data_queue_finish = mysql_fetch_assoc($query_queue_finish);
							$finish_time = $data_queue_finish['time_end'];
							
							// Check queue status
							if(date('Y-m-d') == $data_queue['date_start'])
							{
								$queue_status = (get_timestamp($finish_time) < get_timestamp(date('H:i:s'))) ? '<span class="green bold">ดำเนินการเสร็จแล้ว</span>' : '<span class="red bold">รอดำเนินการ</span>';
							}
							else if(get_timestamp($data_queue['date_start']) < get_timestamp(date('Y-m-d')))
							{
								$queue_status = '<span class="green bold">ดำเนินการเสร็จแล้ว</span>';
							}
							else
							{
								$queue_status = '<span class="red bold">รอดำเนินการ</span>';
							}
							
							$queue_card = '<a href="order_read.php?id='.$data_queue['id_order'].'" class="black"><div class="gadget">
												<ul class="left">
													<li><b>สถานะ : </b>'.$queue_status.'</li>
													<li><b>เวลา : </b>'.$data_queue['time_start'].' - '.$finish_time.'</li>
													<li><b>เลขที่ใบรายการ : </b>'.zero_fill(4,$data_queue['id_order']).'</li>
													<li><b>ลูกค้า : </b>'.$data_queue['customer'].' ('.$data_queue['total_item'].' ชิ้น)</li> 
												</ul>
											</form>
										  </div></a>';
										  
							echo '<td rowspan="4">'.$queue_card.'</td>';
						}
					}
					else
					{
						$id_order[$id_machine[($loop - 1)]][$id_queue] = '';
						echo '<td></td>';
					}
				}
				
				echo '</tr>';
				
				$id_queue++;
			}
			
			echo '</table>';
			?>
		</div>
		<div style="clear:both"></div>
	</div>
	<?php include("inc.footer.php"); ?>
</div>
</body>
</html>
