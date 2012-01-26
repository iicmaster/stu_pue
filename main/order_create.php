<?php 
require_once("../include/session.php");  
require_once("../include/connect.php");

if(isset($_POST['submit']))
{
	//print_array($_POST);
	//exit();
	
		$message = '';
	
	// ----------------------------------------------------------------------------
	// Start transaction
	// ----------------------------------------------------------------------------
	
		mysql_query("BEGIN");	
		
	// ----------------------------------------------------------------------------
	// Calculate due date - time
	// ----------------------------------------------------------------------------
	
	if($_POST['id_product_group'] == 3)
	{
		// ------------------------------------------------------------------------
		// Get due date
		// ------------------------------------------------------------------------
		
			$due_date = date('Y-m-d', strtotime('+ 1 days'));
			
			//echo '$due_date = '.$due_date.'<br />';
			//exit();
		
		// ------------------------------------------------------------------------
		// Get due time
		// ------------------------------------------------------------------------
		
			$sql = 'SELECT *
							
					FROM queue_time
						
					WHERE
						NOW() BETWEEN time_start and time_end
						OR 
						NOW() < time_start';
						
			//echo $sql.'<hr />';
										
			// RollBack transaction and show error message when query error						
			if( ! $query = mysql_query($sql))
			{
				echo 'Get due time';
				echo '<hr />';
				echo mysql_error();
				echo '<hr />';
				echo $sql;
				mysql_query("ROLLBACK");
				exit();
			}
			
			$query_rows = mysql_num_rows($query);
			
			if($query_rows == 0)
			{
				$due_time = '9:00:00';
				$due_date = date('Y-m-d', strtotime('+ 2 days'));
			}
			else
			{
				$data		= mysql_fetch_assoc($query);	
				$due_time	= $data['time_start'];
			}
			
			$finish_date = $due_date;
			$finish_time = $due_time;
			
			//echo '$due_date = '.$due_date.'<br />';
			//echo '$due_time = '.$due_time.'<br />';
			//exit();
	}
	else
	{
		// ------------------------------------------------------------------------
		// Check & update customer credit
		// ------------------------------------------------------------------------
		
			if($_POST['is_member'] == 1)
			{
				$credit = $_POST['credit'];
			
				$sql = 'UPDATE customer 
						SET credit = "'.$credit.'"
						WHERE id = "'.$_POST['id_customer'].'"';
				
				// RollBack transaction and show error message when query error						
				if( ! $query = mysql_query($sql))
				{
					echo 'Update customer credit';
					echo '<hr />';
					echo mysql_error();
					echo '<hr />';
					echo $sql;
					mysql_query("ROLLBACK");
					exit();
				}
			}
			
		// ------------------------------------------------------------------------
		// Check is washing
		// ------------------------------------------------------------------------
			
			if($_POST['id_order_type'] == 1 || $_POST['id_order_type'] == 2)
			{	
				// ----------------------------------------------------------------
				// Select machine size
				// ----------------------------------------------------------------
				
					if($_POST['total_item'] < 30)
					{
						$id_machine_size = 1;
					}
					else if($_POST['total_item'] < 40)
					{
						$id_machine_size = 2;
					}
					else
					{
						$id_machine_size = 3;
					}
					
					//echo $id_machine_size;
					//echo exit();
					
				// ----------------------------------------------------------------
				// Get queue at current time
				// ----------------------------------------------------------------
				
					$sql = 'SELECT id
					
							FROM queue_time 
							
							WHERE 
								NOW() BETWEEN time_start and time_end
								OR 
								NOW() < time_start';
					
					// RollBack transaction and show error message when query error						
					if( ! $query = mysql_query($sql))
					{
						echo 'Washing - Get queue at current time';
						echo '<hr />';
						echo mysql_error();
						echo '<hr />';
						echo $sql;
						mysql_query("ROLLBACK");
						exit();
					}
					
					$query_rows = mysql_num_rows($query);
					
					if($query_rows > 0)
					{
						$data = mysql_fetch_assoc($query);	
						$id_current_queue_washing = $data['id'];
					}
					else
					{
						$id_current_queue_washing = 48;
					}
					
					//echo $id_current_queue_washing;
					//exit();
				
				// ----------------------------------------------------------------
				// Get last washing queue detail
				// ----------------------------------------------------------------
					
					if($id_current_queue_washing > 44)
					{
						$loop_washing = 1;
					}
					else
					{
						$loop_washing = 0;
					}
					
					do
					{
						// Get last washing queue
						$sql = 'SELECT 
									MAX(id_queue_time) + 1 AS "id_queue_time",
									queue_wash.id_machine,
									date_start
									
								FROM queue_wash
								
								LEFT JOIN machine
								ON queue_wash.id_machine = machine.id
								
								WHERE
									date_start = DATE_ADD(CURDATE(),INTERVAL '.$loop_washing.' DAY)
									AND
									machine.id_machine_size = "'.$id_machine_size.'"
									AND
									machine.is_enable = 1
	
								GROUP BY queue_wash.id_machine
									
								ORDER BY id_queue_time';
								
						//echo $sql;			
					
						// RollBack transaction and show error message when query error						
						if( ! $query = mysql_query($sql))
						{
							echo 'Get last washing queue';
							echo '<hr />';
							echo mysql_error();
							echo '<hr />';
							echo $sql;
							mysql_query("ROLLBACK");
							exit();
						}
						
						$data_queue_wash = mysql_fetch_assoc($query);	
						$machine_in_queue = mysql_num_rows($query);
						
						//print_array($data_queue_wash);
						//echo $machine_in_queue;
						//exit();
						
						// Get total machine
						$sql = 'SELECT COUNT(id) AS "total" 
									
								FROM machine 
								
								WHERE 
									id_machine_type = 1
									AND
									is_enable = 1
									AND
									id_machine_size = '.$id_machine_size;
						
						// RollBack transaction and show error message when query error						
						if( ! $query = mysql_query($sql))
						{
							echo 'Get total machine';
							echo '<hr />';
							echo mysql_error();
							echo '<hr />';
							echo $sql;
							mysql_query("ROLLBACK");
							exit();
						}
						
						$data_total_machine = mysql_fetch_assoc($query);
						$total_machine = $data_total_machine['total'];	
						
						//echo $total_machine;
						//exit();
						
						if($data_queue_wash['id_queue_time'] == "")
						{
							// Get id washing machine
							$sql = 'SELECT id 
										
									FROM machine 
									
									WHERE 
										id_machine_type = 1 
										AND
										is_enable = 1
										AND 
										id_machine_size = '.$id_machine_size;
							
							//echo $sql;
							
							// RollBack transaction and show error message when query error						
							if( ! $query = mysql_query($sql))
							{
								echo 'Get id washing machine';
								echo '<hr />';
								echo mysql_error();
								echo '<hr />';
								echo $sql;
								mysql_query("ROLLBACK");
								exit();
							}
							
							$data = mysql_fetch_assoc($query);
							
							$data_queue_wash['id_queue_time']	= 1;	
							$data_queue_wash['id_machine']		= $data['id'];	
							$data_queue_wash['date_start']		= date('Y-m-d', strtotime('+ '.$loop_washing.' days'));
						}
						else if($machine_in_queue < $total_machine)
						{
							// Get id washing machine
							$sql = 'SELECT machine.id
										 
									FROM machine
									
									WHERE 
										machine.is_enable = 1
										AND
										machine.id_machine_type = 1
										AND
										machine.id_machine_size = '.$id_machine_size.'
										AND
										machine.id NOT IN (SELECT DISTINCT id_machine FROM queue_wash WHERE date_start = DATE_ADD(CURDATE(),INTERVAL '.$loop_washing.' DAY))';
							
							//echo $sql;
							
							// RollBack transaction and show error message when query error						
							if( ! $query = mysql_query($sql))
							{
								echo 'Get id washing machine ($machine_in_queue < $total_machine)';
								echo '<hr />';
								echo mysql_error();
								echo '<hr />';
								echo $sql;
								mysql_query("ROLLBACK");
								exit();
							}
							
							$data = mysql_fetch_assoc($query);
							
							$data_queue_wash['id_queue_time']	= 1;	
							$data_queue_wash['id_machine']		= $data['id'];	
							$data_queue_wash['date_start']		= date('Y-m-d', strtotime('+ '.$loop_washing.' days'));
						}
						
						if($data_queue_wash['id_queue_time'] < $id_current_queue_washing && $loop_washing == 0)
						{
							$data_queue_wash['id_queue_time'] = $id_current_queue_washing;
						}
						
						$loop_washing++;
					}
					while($data_queue_wash['id_queue_time'] > 44);
					
					//print_array($data_queue_wash);
					//exit();
					
				// ----------------------------------------------------------------
				// Get finish time
				// ----------------------------------------------------------------
				
					// Working time (queue)
					$working_time = 4;
					
					$sql = 'SELECT time_start
								
							FROM queue_time
							
							WHERE id = "'.($data_queue_wash['id_queue_time'] + $working_time).'"';
						
					//echo $sql.'<hr />';	
											
					// RollBack transaction and show error message when query error						
					if( ! $query = mysql_query($sql))
					{
						echo 'Washing - Get finish time';
						echo '<hr />';
						echo mysql_error();
						echo '<hr />';
						echo $sql;
						mysql_query("ROLLBACK");
						exit();
					}
					
					$data = mysql_fetch_assoc($query);	
					$finish_time = $data['time_start'];
			
					//echo '$finish_time = '.$finish_time.'<br />';
					//exit();
			}
				
		// ------------------------------------------------------------------------
		// Check is ironing
		// ------------------------------------------------------------------------
		
			if($_POST['id_order_type'] == 1 || $_POST['id_order_type'] == 3)
			{	
				// ----------------------------------------------------------------
				// Get queue at current time
				// ----------------------------------------------------------------
				
					$curent_time = ($_POST['id_order_type'] == 1) ? $finish_time : date('H:i:s');
				
					$sql = 'SELECT id
					
							FROM queue_time
							 
							WHERE 
								"'.$curent_time.'" BETWEEN time_start and time_end
								OR 
								"'.$curent_time.'" < time_start';
								
					//echo $sql;
					
					// RollBack transaction and show error message when query error						
					if( ! $query = mysql_query($sql))
					{
						echo 'Ironing - Get queue at current time';
						echo '<hr />';
						echo mysql_error();
						echo '<hr />';
						echo $sql;
						mysql_query("ROLLBACK");
						exit();
					}
					
					$query_rows = mysql_num_rows($query);
					
					if($query_rows > 0)
					{
						$data = mysql_fetch_assoc($query);	
						$id_current_queue_ironing = $data['id'];
					}
					else
					{
						$id_current_queue_ironing = 48;
					}
					
					//echo '$id_current_queue_ironing = '.$id_current_queue_ironing.'<br />';
					//exit();
				
				// ----------------------------------------------------------------
				// Get last ironing queue detail
				// ----------------------------------------------------------------
					
					if($_POST['id_order_type'] == 1 && $id_current_queue_washing > 44)
					{
						$loop_ironing = $loop_washing - 1;
					}
					else if($id_current_queue_ironing > 44)
					{
						$loop_ironing = 1;
					}
					else
					{
						$loop_ironing = 0;
					}
						
					//echo '$loop_ironing = '.$loop_ironing.'<br />';
					//exit();
					
					do
					{
						// Get last ironing queue
						$sql = 'SELECT 
									MAX(id_queue_time) + 1 AS "id_queue_time",
									queue_iron.id_machine,
									date_start
									
								FROM queue_iron
								
								LEFT JOIN machine
								ON queue_iron.id_machine = machine.id
								
								WHERE 
									date_start = DATE_ADD(CURDATE(),INTERVAL '.$loop_ironing.' DAY)
									AND
									machine.is_enable = 1
	
								GROUP BY queue_iron.id_machine
									
								ORDER BY id_queue_time';
									
						//echo $sql.'<hr />';
						//exit();
					
						// RollBack transaction and show error message when query error						
						if( ! $query = mysql_query($sql))
						{
							echo 'Get last ironing queue';
							echo '<hr />';
							echo mysql_error();
							echo '<hr />';
							echo $sql;
							mysql_query("ROLLBACK");
							exit();
						}
						
						$data_queue_iron = mysql_fetch_assoc($query);	
						$machine_in_queue = mysql_num_rows($query);
						
						//print_array($data_queue_iron);
						//echo '$machine_in_queue = '.$machine_in_queue.'<br />';
						//exit();
						
						
						// Get total machine
						$sql = 'SELECT COUNT(id) AS "total" 
						
								FROM machine 
								
								WHERE 
									id_machine_type = 3
									AND
									is_enable = 1';
						
						// RollBack transaction and show error message when query error						
						if( ! $query = mysql_query($sql))
						{
							echo 'Get total machine';
							echo '<hr />';
							echo mysql_error();
							echo '<hr />';
							echo $sql;
							mysql_query("ROLLBACK");
							exit();
						}
						
						$data_total_machine = mysql_fetch_assoc($query);
						$total_machine = $data_total_machine['total'];	
						
						//echo '$total_machine = '.$total_machine.'<br />';
						//exit();
						
						if($machine_in_queue == 0)
						{	
							// Get id iron machine
							$sql = 'SELECT id 
							
									FROM machine 
									
									WHERE 
										id_machine_type = 3
										AND
										is_enable = 1';
							
							// RollBack transaction and show error message when query error						
							if( ! $query = mysql_query($sql))
							{
								echo 'Get id iron machine ($data_queue_iron[\'id_queue_time\'] == "")';
								echo '<hr />';
								echo mysql_error();
								echo '<hr />';
								echo $sql;
								mysql_query("ROLLBACK");
								exit();
							}
							
							$data = mysql_fetch_assoc($query);
							
							$data_queue_iron['id_queue_time']	= 1;	
							$data_queue_iron['id_machine']		= $data['id'];	
							$data_queue_iron['date_start']		= date('Y-m-d', strtotime('+ '.$loop_ironing.' days'));
						}
						else if($machine_in_queue < $total_machine)
						{
							// Get id iron machine
							$sql = 'SELECT machine.id
										 
									FROM machine
									
									WHERE 
										machine.is_enable = 1
										AND
										machine.id_machine_type = 3
										AND
										machine.id NOT IN (SELECT DISTINCT id_machine FROM queue_iron WHERE date_start = DATE_ADD(CURDATE(),INTERVAL '.$loop_ironing.' DAY))';
							
							//echo $sql;
							
							// RollBack transaction and show error message when query error						
							if( ! $query = mysql_query($sql))
							{
								echo 'Get id iron machine ($machine_in_queue < $total_machine)';
								echo '<hr />';
								echo mysql_error();
								echo '<hr />';
								echo $sql;
								mysql_query("ROLLBACK");
								exit();
							}
							
							$data = mysql_fetch_assoc($query);
							
							$data_queue_iron['id_queue_time']	= 1;	
							$data_queue_iron['id_machine']		= $data['id'];
							$data_queue_iron['date_start']		= date('Y-m-d', strtotime('+ '.$loop_ironing.' days'));		
						}
						
						if($loop_ironing == 0 && ($data_queue_iron['id_queue_time'] < $id_current_queue_ironing))
						{
							$data_queue_iron['id_queue_time'] = $id_current_queue_ironing;
						}
						/*else if($_POST['id_order_type'] == 1 && ($data_queue_iron['id_queue_time'] < $id_current_queue_ironing) && ($id_current_queue_ironing <= 44))
						{
							$data_queue_iron['id_queue_time'] = $id_current_queue_ironing;
						}*/
						
						$loop_ironing++;
					}
					while($data_queue_iron['id_queue_time'] > 44);
					
					//print_array($data_queue_iron);
					//exit();
				
				// ----------------------------------------------------------------
				// Get finish time
				// ----------------------------------------------------------------
				
					// Working time (queue)
					$working_time = 4;
					
					$sql = 'SELECT time_start
								
							FROM queue_time
							
							WHERE id = "'.($data_queue_iron['id_queue_time'] + $working_time).'"';
							
					//echo $sql.'<hr />';
											
					// RollBack transaction and show error message when query error						
					if( ! $query = mysql_query($sql))
					{
						echo 'Ironing - Get finish time';
						echo '<hr />';
						echo mysql_error();
						echo '<hr />';
						echo $sql;
						mysql_query("ROLLBACK");
						exit();
					}
					
					$data = mysql_fetch_assoc($query);	
					$finish_time = $data['time_start'];
			
					//print_array($data_queue_iron);
					//echo '$finish_time = '.$finish_time.'<br />';
					//exit();
			}
				
		// ------------------------------------------------------------------------
		// Get due time
		// ------------------------------------------------------------------------
		
			$sql = 'SELECT id
			
					FROM queue_time
					 
					WHERE "'.$finish_time.'" BETWEEN time_start AND time_end';
			
			// RollBack transaction and show error message when query error						
			if( ! $query = mysql_query($sql))
			{
				echo 'Get due time';
				echo '<hr />';
				echo mysql_error();
				echo '<hr />';
				echo $sql;
				mysql_query("ROLLBACK");
				exit();
			}
			
			$query_rows = mysql_num_rows($query);
			$data = mysql_fetch_assoc($query);	
			
			$id_queue_time_finish = $data['id'];
			
			// Add buffer time
			if($id_queue_time_finish > 40 && $_POST['id_order_type'] == 1)
			{
				$due_time = '09:00:00';
			}
			else if($id_queue_time_finish > 44 && $_POST['id_order_type'] != 1)
			{
				$due_time = '09:00:00';
			}
			else if($_POST['id_order_type'] == 1)
			{
				$sql = 'SELECT time_start
							
						FROM queue_time
						
						WHERE id = "'.($id_queue_time_finish + 8).'"';
											
				// RollBack transaction and show error message when query error						
				if( ! $query = mysql_query($sql))
				{
					echo 'Add buffer time - Ironing';
					echo '<hr />';
					echo mysql_error();
					echo '<hr />';
					echo $sql;
					mysql_query("ROLLBACK");
					exit();
				}
					
				$data = mysql_fetch_assoc($query);	
				$due_time = $data['time_start'];
			}
			else
			{
				$sql = 'SELECT time_start
							
						FROM queue_time
						
						WHERE id = "'.($id_queue_time_finish + 4).'"';
											
				// RollBack transaction and show error message when query error						
				if( ! $query = mysql_query($sql))
				{
					echo 'Add buffer time - Ironing';
					echo '<hr />';
					echo mysql_error();
					echo '<hr />';
					echo $sql;
					mysql_query("ROLLBACK");
					exit();
				}
					
				$data = mysql_fetch_assoc($query);	
				$due_time = $data['time_start'];
			}
			
			//echo '$id_queue_time_finish = '.$id_queue_time_finish.'<br />';
			//echo '$due_time = '.$due_time.'<br />';
			//exit();
			
		// ------------------------------------------------------------------------
		// Get due date
		// ------------------------------------------------------------------------
		
			if($id_queue_time_finish > 44 && $_POST['id_order_type'] == 2)
			{
				$working_day = $loop_washing;
			}
			if($id_queue_time_finish > 44 && $_POST['id_order_type'] == 3)
			{
				$working_day = $loop_ironing;
			}
			else if($id_queue_time_finish > 40 && $_POST['id_order_type'] == 1)
			{
				$working_day = $loop_ironing;
			}
			else if($_POST['id_order_type'] != 2)
			{
				$working_day = $loop_ironing - 1;
			}
			else
			{
				$working_day = $loop_washing - 1;
			}
			
			$due_date = date('Y-m-d', strtotime('+'.$working_day.' days'));
			
			if($_POST['id_order_type'] == 2)
			{
				$finish_date = $data_queue_wash['date_start'];
			}
			else
			{
				$finish_date = $data_queue_iron['date_start'];
			}
			
			//echo '$loop_washing = '.$loop_washing.'<br />';
			//echo '$loop_ironing = '.$loop_ironing.'<br />';
			//echo '$working_day = '.$working_day.'<br />';
			//echo '$due_time = '.$due_time.'<br />';
			//echo '$due_date = '.$due_date.'<br />';
			//exit();
	}
				
	// ----------------------------------------------------------------------------
	// Create order head
	// ----------------------------------------------------------------------------
		
		$total_price = ($_POST['is_member'] == 1 && $_POST['id_product_group'] == 1) ? 0 : $_POST['total_price'] ;
		
		$sql = 'INSERT INTO order_head
				SET
					id_customer			= "'.$_POST['id_customer'].'",
					id_order_type 		= "'.$_POST['id_order_type'].'",
					id_product_group	= "'.$_POST['id_product_group'].'",
					total_item			= "'.$_POST['total_item'].'",
					total_price			= "'.$total_price.'",
					date_finish			= "'.$finish_date.' '.$finish_time.'",
					date_due			= "'.$due_date.' '.$due_time.'",
					date_create			= "'.date('Y-m-d H:i:s').'"';
								
		// RollBack transaction and show error message when query error						
		if( ! $query = mysql_query($sql))
		{
			echo 'Create order head';
			echo '<hr />';
			echo mysql_error();
			echo '<hr />';
			echo $sql;
			mysql_query("ROLLBACK");
			exit();
		}
		
	// ----------------------------------------------------------------------------
	// Get order id
	// ----------------------------------------------------------------------------
		
		$sql = 'SELECT MAX(id) AS id FROM order_head';
								
		// RollBack transaction and show error message when query error						
		if( ! $query = mysql_query($sql))
		{
			echo 'Get order head id';
			echo '<hr />';
			echo mysql_error();
			echo '<hr />';
			echo $sql;
			mysql_query("ROLLBACK");
			exit();
		}
		
		$data = mysql_fetch_array($query);
		$id_order = $data['id'];
	
	// ----------------------------------------------------------------------------
	// Create order item
	// ----------------------------------------------------------------------------
		
		foreach($_POST['selected_product_id'] as $id_product)
		{	
			if($_POST['id_product_group'] != 3)
			{
				$_POST['order_item'][$id_product]['product_name']	= '';
				$_POST['order_item'][$id_product]['product_price']	= '';
			}
			
			$sql = 'INSERT INTO order_item
					SET
						id_order		= "'.$id_order.'",
						id_product		= "'.$id_product.'",
						quantity		= "'.$_POST['order_item'][$id_product]['quantity'].'",
						product_name	= "'.$_POST['order_item'][$id_product]['product_name'].'",
						product_price	= "'.$_POST['order_item'][$id_product]['product_price'].'",
						remark			= "'.$_POST['order_item'][$id_product]['remark'].'"';
														
			// RollBack transaction and show error message when query error						
			if( ! $query = mysql_query($sql))
			{
				echo 'Create order item';
				echo '<hr />';
				echo mysql_error();
				echo '<hr />';
				echo $sql;
				mysql_query("ROLLBACK");
				exit();
			}
		}
		
	// ----------------------------------------------------------------------------
	// Create queue 
	// ----------------------------------------------------------------------------
		
		if($_POST['id_product_group'] != 3)
		{
			if($_POST['id_order_type'] == 1 || $_POST['id_order_type'] == 2)
			{	
				for($i = 0; $i < 4; $i++)
				{
					$sql = 'INSERT INTO queue_wash
							SET 
								id_machine		= "'.$data_queue_wash['id_machine'].'",
								id_order		= "'.$id_order.'",
								id_queue_time	= "'.($data_queue_wash['id_queue_time'] + $i).'",
								date_start		= "'.$data_queue_wash['date_start'].'",
								date_create		= "'.date('Y-m-d').'"';
								
					// RollBack transaction and show error message when query error						
					if( ! $query = mysql_query($sql))
					{
						echo 'Add washing queue';
						echo '<hr />';
						echo mysql_error();
						echo '<hr />';
						echo $sql;
						mysql_query("ROLLBACK");
						exit();
					}
				}
				
			}
			
			if($_POST['id_order_type'] == 1 || $_POST['id_order_type'] == 3)
			{	
				for($i = 0; $i < 4; $i++)
				{
					$sql = 'INSERT INTO queue_iron
							SET 
								id_machine		= "'.$data_queue_iron['id_machine'].'",
								id_order		= "'.$id_order.'",
								id_queue_time	= "'.($data_queue_iron['id_queue_time'] + $i).'",
								date_start		= "'.$data_queue_iron['date_start'].'",
								date_create		= "'.date('Y-m-d H:i:s').'"';
								
					// RollBack transaction and show error message when query error						
					if( ! $query = mysql_query($sql))
					{
						echo 'Add iron queue';
						echo '<hr />';
						echo mysql_error();
						echo '<hr />';
						echo $sql;
						mysql_query("ROLLBACK");
						exit();
					}
				}
			}
		}
		
	// ----------------------------------------------------------------------------
	// Create receive 
	// ----------------------------------------------------------------------------
	
		$sql = 'INSERT INTO customer_receipt 
				SET 
					id_receipt_type	= 1, 
					id_customer		= '.$_POST['id_customer'].', 
					id_order		= '.$id_order.',
					amount			= '.$total_price.', 
					date_create		= "'.date('Y-m-d H:i:s').'"';
						
		// RollBack transaction and show error message when query error						
		if( ! $query = mysql_query($sql))
		{
			echo 'Create receipt';
			echo '<hr />';
			echo mysql_error();
			echo '<hr />';
			echo $sql;
			mysql_query("ROLLBACK");
			exit();
		}
		
	// ----------------------------------------------------------------------------
	// Get receipt id
	// ----------------------------------------------------------------------------
			
		$sql = 'SELECT MAX(id) AS id FROM customer_receipt';
								
		// RollBack transaction and show error message when query error						
		if( ! $query = mysql_query($sql))
		{
			echo 'Get customer id';
			echo '<hr />';
			echo mysql_error();
			echo '<hr />';
			echo $sql;
			mysql_query("ROLLBACK");
			exit();
		}
		
		$data = mysql_fetch_array($query);
		$id_receipt = $data['id'];
			
	// ----------------------------------------------------------------------------
	// Open receipt page
	// ----------------------------------------------------------------------------
		
		$message .= '<script type="text/javascript">
						window.open(\'customer_receipt_print_1.php?id='.$id_receipt.'\', \'_blank\');
					 </script>'; 
	
	// ----------------------------------------------------------------------------
	// Commit transaction
	// ----------------------------------------------------------------------------
	
		mysql_query("COMMIT");

	// ----------------------------------------------------------------------------
	// Report
	// ----------------------------------------------------------------------------
		
		/*if($_POST['id_product_group'] == 3)
		{
			$url_target	= 'order_update.php?id='.$id_order;
		}
		else if($_POST['id_order_type'] == 1 || $_POST['id_order_type'] == 2)
		{
			$url_target	= 'queue_wash.php?date='.$data_queue_wash['date_start'];
		}
		else if($_POST['id_order_type'] == 3)
		{
			$url_target	= 'queue_iron.php?date='.$data_queue_iron['date_start'];
		}*/
		
		$url_target		= 'index.php';
		$css			= '../css/style.css';
		$title			= 'สถานะการทำงาน';
		$button_text	= 'เสร็จ';
		$message	   .= '<li class="green">สร้างใบรายการเสร็จสมบูรณ์</li>
						   <p class="center" style="margin-top:25px;">
							   <a href="order_create.php?id='.$_POST['id_customer'].'" class="iic_button">ทำรายการต่อ</a>
						   </p>';
		
		require_once("../iic_tools/views/iic_report.php");
		exit();
		
	// ----------------------------------------------------------------------------
	// End
	// ----------------------------------------------------------------------------
}

// --------------------------------------------------------------------------------
// Get customer data
// --------------------------------------------------------------------------------

$sql	= '	SELECT customer.* ,
			order_head.id AS id_order_head
			
			FROM customer 
			
			LEFT JOIN order_head
			ON order_head.id_customer = customer.id
			
			WHERE customer.id = "'.$_GET['id'].'"';
			
$query	= mysql_query($sql) or die(mysql_error());
$data	= mysql_fetch_array($query);

$is_member = $data['is_member'];
$customer_type = ($data['is_member'] == 1) ? 'ลูกค้ารายเดือน' : 'ลูกค้าทั่วไป'; 

// --------------------------------------------------------------------------------
// End 
// --------------------------------------------------------------------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ใบรายการ</title>
<?php include('inc.css.php'); ?>
<style type="text/css">
#customer_info li { margin: 20px 0px; }

#id, #name, #id_order_type, #id_product_group { margin-right: 20px; }

#id
{
	width: 40px;
	text-align: center;
}

#name { width: 200px; }

#credit
{
	width: 20px;
	text-align: center;
}

.order_item { display: none; }

form input[type=text], form input[type=password], form textarea, form select { min-width: 30px; }

form input[id^=remark] { width: 190px; }

#order_footer { margin-top: 25px; }

li { margin-left: 0px; }

.product_name { width: 300px; }

.price { display: none; }

.price_1 { display: table-cell; }
</style>
<script type="text/javascript" src="../js/jquery-1.5.1.min.js"></script>
<script src="../js/jquery-ui-1.8.11.min.js" type="text/javascript"></script>

<!-- jQuery - Form validate -->
<link rel="stylesheet" type="text/css" href="../iic_tools/css/jquery.validate.css" />
<script type="text/javascript" src="../iic_tools/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="../iic_tools/js/jquery.validate.additional-methods.js"></script>
<script type="text/javascript" src="../iic_tools/js/jquery.validate.messages_th.js"></script>
<script type="text/javascript" src="../iic_tools/js/jquery.validate.config.js"></script>
<script type="text/javascript">
$(function()
{
	// Select link
	$("#menu #order").addClass('active');
	
	// Show first group
	$("#group-1").show();
	
	// Reset value when change order type
	$("#id_product_group").change(function()
	{
		var id_group = $(this).val();
		var is_member = $('#is_member').val();
		
		$("div.order_item").hide();
		
		reset_order_item()
		
		$("#group-" + id_group).show();
		
		// Disable "Iron" option if product group is "bedding"
		if(id_group == '2')
		{
			$("#id_order_type option[value=3]").hide()
			$("#id_order_type").val('1');
			$("#div_total_price").show();
		}
		else
		{
			$("#id_order_type option").show();
			$("#div_total_price").hide();
		}
		
		if(id_group == '2' || id_group == '3')
		{
			$("#div_total_price").show();
		}
		else
		{
			$("#div_total_price").hide();
		}
	});
	
	// Calculate order item price
	$('select[id^=qty]').change(function()
	{	
		//if($("#id_product_group").val() != '3')
		//{
			var credit = parseInt($('#credit').val());
			var is_member = $('#is_member').val();
			
			if( ! calculate_grand_total())
			{
				if(credit == 0)
				{
					alert('กรูณาต่ออายุสมาชิก หรือ ปรับสถานะ');
					$(this).val(0);
					$(this).parent().next().find('input[type=text]').val(0);
					$('input[type=submit]').hide();
				}
				else if(credit != NaN && credit < 0 )
				{
					alert('คุณเลือกผ้าเกินจำนวน เครดิดคงเหลือ กรูณาเลือกใหม่่');
					
					// Reset select to default value;
					$('#credit').val(credit);
				}
				else
				{
					alert('จำนวนรวมของผ้าที่คุณเลือกเกิน 50 ชิ้น, โปรดเลือกจำนวนผ้าไม่ให้เกิน 50 ชิ้น ต่อหนึ่งใบรายการ');
					
					// Reset select to default value;
					$(this).val(0);
					$(this).parent().next().find('input[type=text]').val(0);
				}
			}
			else
			{
				var qty = parseInt($(this).val());
				
				if(qty == 0)
				{
					$(this).parent().parent().find('input[type=checkbox]').removeAttr('checked');
				}
				else
				{
					$(this).parent().parent().find('input[type=checkbox]').attr('checked', 'checked');
				}
			}
		//}	
	});
	
	// Calculate order item price
	$('#id_order_type').change(function()
	{
		var order_type = $(this).val();
		
		$('.price').css('display', 'none');
		$('.price_' + order_type).css('display', 'table-cell');
		
		//if($("#id_product_group").val() != '3')
		//{
			calculate_grand_total()
		//}
	});
	
	$('input[id^=price_manual_wash]').blur(function()
	{
		calculate_grand_total()
	});
	
	$("form").validate();
	
	$('form').submit(function()
	{
		var total_item 		= parseInt($("#total_item").find('b').html());
		var product_group 	= parseInt($("#id_product_group").val());
		
		var form_validate = $('form').valid();
		
		//alert(form_validate);
		
		if(total_item < 10 && product_group == 1)
		{
			alert('โปรดเลือกจำนวนผ้าอย่างน้อย 10 ชิ้น');
			
			return false;
		}
		else if(product_group == 3)
		{
			var is_empty = true;
			
			// Check total item
			if(total_item == 0)
			{
				alert('โปรดเลือกจำนวนผ้าอย่างน้อย 1 ชิ้น');
			
				return false;
			}
			
			$('#group-3').find('input:checked').each(function(index)
			{
				is_empty = true;
				
				var id = $(this).val();
				
				// Check product name
				if($('#product_name_' + id).val() == '')
				{
					alert('โปรดระบุรายการ');
					
					$('#product_name_' + id).focus();
					
					return false;
				}
				else
				{
					is_empty = false
				}
			});
			
			if(is_empty)
			{
				return false;
			}
		}
	});
	
});

function calculate_grand_total()
{
	var id_product_group	= parseInt($('#id_product_group').val());
	var credit				= parseInt($('#credit').attr('rel'));
	var total_item			= 0;
	var grand_total			= 0;
	var is_member 			= $('#is_member').val();
		
	if(isNaN(credit))
	{
		credit = 0;
		//alert(credit);
	}
	
	$('tbody tr').each(function(index) 
	{
		var id_order_type		= parseInt($('#id_order_type').val());
		var price_wash			= parseInt($(this).find('input[id^=price_wash]').val());
		var price_iron			= parseInt($(this).find('input[id^=price_iron]').val());
		var qty					= parseInt($(this).find('select[id^=qty]').val());
		var total_price			= 0;
		
		// Calculate order item price
		if(id_product_group != 3)
		{	
			switch(id_order_type)
			{
				case 1:
				  total_price = (price_wash + price_iron) * qty
				  break;
				case 2:
				  total_price = price_wash * qty
				  break;	
				case 3:
				  total_price = price_iron * qty
				  break;
			}
		}
		else
		{
			var price_manual_wash = parseInt($(this).find('input[id^=price_manual_wash]').val());
			
			total_price = price_manual_wash * qty
		}
		
		// Set total
		$(this).find('input[id^=total]').val(total_price);
	});	
	
	// Calculate total item
	$('select[id^=qty]').each(function(index) 
	{
		total_item += parseInt($(this).val());
	});
	
	
	// Calculate grand total
	$('input[id^=total]').each(function(index) 
	{
		var sub_total = parseInt($(this).val());
		
		if(isNaN(sub_total))
		{
			sub_total = 0;
		}
		
		grand_total += sub_total;
	});
	
	// Check and update user credit
	if(id_product_group == 1)
	{
		if(is_member == 1)
		{
			var new_credit = credit - total_item;
			
			if(new_credit >= 0)
			{		
				$('#credit').val(credit - total_item);
			}
			else
			{
				return false
			}
		}
	}
	
	//alert(total_item);
	
	if(total_item <= 50)
	{
		// Set total item
		$("#total_item").find('b').html(total_item);
		$("input[name=total_item]").val(total_item);
		
		// Set grand total
		$("#grand_total").find('b').html(grand_total);
		$("input[name=total_price]").val(grand_total);
		return true;
	}
	else
	{
		return false;	
	}
}

function reset_order_item()
{
	$('#credit').val($('#credit').attr('rel'));
	
	$("input[type=checkbox]").removeAttr('checked');
	
	$("select[id^=qty]").val('0');
	$("input[id^=total]").val('0');
	
	$("#total_item").find('b').html('0');
	$("#grand_total").find('b').html('0');
	
	$("input[name=total_item]").val('0');
	$("input[name=total_price]").val('0');
}

</script>
<style type="text/css">
body, td, th { color: #666; }
</style>
</head>

<body>
<div id="container">
	<?php include('inc.header.php'); ?>
	<div id="content">
		<form action="" method="post">
			<div id="date" class="float_r">วันที่ : <?php echo change_date_format(date('Y-m-d')) ?></div>
			<h1>สร้างใบรายการ</h1>
			<hr />
			<div id="customer_info">
				<ul>
					<li>
						<p style="font-size:19px">
						<td for="id_order_head" >รหัสใบรายการ : <?php echo zero_fill(4, $data['id_order_head']+1);?></td>
						<br/>
						<td >ประเภท : <?php echo $customer_type; ?></td>
						<br/>
						<td for="id" >รหัสลูกค้า : <?php echo zero_fill(4, $data['id']); ?></td>
						<br/>
						<input type="hidden" name="id_customer" value="<?php echo $data['id'] ?>" />
						<input type="hidden" id="is_member" name="is_member" value="<?php echo $data['is_member'] ?>" />
						<td for="name" >ชื่อ : <?php echo $data['name']; ?> <?php echo $data['lastname']; ?></td>
						<br/>
						<?php 
						if($data['is_member'] == 1 && $data['date_exp'] > date('Y-m-d'))
						{
							echo '<td for="credit" class="inline">จำนวนผ้าคงเหลือ : 
									  <input id="credit" name="credit" type="text" value="'.$data['credit'].'" rel="'.$data['credit'].'" readonly="readonly" /> ชิ้น 
								  </td>';
						}
						?>
						<td for="id_product_group" class="inline">ประเภทผ้า : </td>
						<select id="id_product_group" name="id_product_group">
							<?php 
							// Select type of order item
							$sql = 'SELECT * FROM product_group';
							$query = mysql_query($sql) or die(mysql_error());
									
							while($data = mysql_fetch_array($query))
							{
								echo '<option value="'.$data['id'].'">'.$data['name'].'</option>';
							}
							?>
						</select>
						<td for="id_order_type" class="inline">ประเภทใบรายการ : </td>
						<select id="id_order_type" name="id_order_type" >
							<?php 
							$sql = 'SELECT * FROM order_type';
							$query = mysql_query($sql) or die(mysql_error());
									
							while($data = mysql_fetch_array($query))
							{
								echo '<option value="'.$data['id'].'">'.$data['name'].'</option>';
							}
							?>
						</select>
						</p>
					</li>
					<li></li>
				</ul>
			</div>
			<hr />
			<div id="order_item">
				<p>
					<?php	
				// Select type of order item
				$sql_product_group = 'SELECT * FROM product_group';
				$query_product_group = mysql_query($sql_product_group) or die(mysql_error());
				
				while($data_product_group = mysql_fetch_array($query_product_group))
				{
					// Generate table header
					echo '<div id="group-'.$data_product_group['id'].'" class="order_item">';
					echo '<table width="100%" border="1" align="center" cellpadding="5" cellspacing="0">
							<thead>
								<tr>
									<th rowspan="2">รายการ</th>
									<th >ค่าบริการต่อชิ้น</th>
									<th rowspan="2" width="80">จำนวนผ้า (ชิ้น)</th>
									<th rowspan="2" width="80">รวมเป็นเงิน</th>
									<th rowspan="2" width="200">หมายเหตุ</th>
								</tr>
								<tr>
									<th width="100" class="price price_1">ซัก - อบ - รีด</th>
									<th width="100" class="price price_2">ซัก - อบ</th>
									<th width="100" class="price price_3">รีด</th>
								</tr>
							</thead>';
								
					// Generate order item
					$sql_product = 'SELECT *
								    FROM product
								    WHERE 
										id_product_group = '.$data_product_group['id'].'
								    ORDER BY 
										id_product_group, 
										name';
									  
					$query_product = mysql_query($sql_product) or die(mysql_error());
								
					echo '<tbody>';
					
					while($data_product = mysql_fetch_array($query_product))
					{
						$selectbox_attr = array(
													'name'	=> 'order_item['.$data_product['id'].'][quantity]',
													'id'	=> 'qty_'.$data_product['id']
												);
												
						$product_name = ($data_product_group['id'] == 3) ? '<input type="text" id="product_name_'.$data_product['id'].'" name="order_item['.$data_product['id'].'][product_name]" class="product_name" />' : $data_product['name'];
												
						echo '<tr rel="'.$data_product['id'].'">
									<td>
										<input type="checkbox" name="selected_product_id[]" id="selected_product_id_'.$data_product['id'].'" value="'.$data_product['id'].'" style="display:none" />
										<input type="hidden" name="order_item['.$data_product['id'].'][price_wash]" id="price_wash_'.$data_product['id'].'" value="'.$data_product['price_wash'].'" />
										<input type="hidden" name="order_item['.$data_product['id'].'][price_iron]" id="price_iron_'.$data_product['id'].'" value="'.$data_product['price_iron'].'" />
										'.$product_name.'
									</td>';

						if($data_product_group['id'] == 3)
						{
							echo ' <td class="center price price_1 price_2 price_3"><input type="text" id="price_manual_wash_'.$data_product['id'].'" name="order_item['.$data_product['id'].'][product_price]" class="right digits" value="0" /></td>';
						}
						else
						{
							echo '	<td class="center price price_1">'.($data_product['price_wash'] + $data_product['price_iron']).'</td>
									<td class="center price price_2">'.$data_product['price_wash'].'</td>
									<td class="center price price_3">'.$data_product['price_iron'].'</td>';
						}
						
						echo '	<td class="center">'.get_numeric_selectbox(0, 50, 0, $selectbox_attr).'</td>
								<td class="center">
									<input type="text" name="order_item['.$data_product['id'].'][total]" id="total_'.$data_product['id'].'" value="0" readonly="readonly" class="right" size="5" />
								</td>
								<td class="center">
									<input type="text" name="order_item['.$data_product['id'].'][remark]" id="remark_'.$data_product['id'].'" />
								</td>
							 </tr>';
					}
					
					echo '</tbody></table></div>';
				}
				?>
				</p>
			</div>
			<hr />
			<div id="order_footer" class="right">
				<h2 id="total_item">จำนวนผ้ารวม : <b>0</b> ชิ้น</h2>
				<p>
					<input name="total_item" type="hidden" value="0" />
				</p>
				<div id="div_total_price" <?php if($is_member == 1) echo 'style="display:none;"'; ?>>
					<h2 id="grand_total">จำนวนเงินรวม : <b>0</b> บาท</h2>
					<p>
						<input name="total_price" type="hidden" value="0" />
					</p>
				</div>
			</div>
			<div class="center">
				<p>
					<input name="id_customer" type="hidden" value="<?php echo $_GET['id'] ?>" />
				</p>
				<hr />
				<p>
					<input name="submit" class="button" type="submit" value="ยืนยันและชำระเงิน" />
				</p>
			</div>
			<p><a href="index.php" class="">กลับ</a> </p>
		</form>
	</div>
	
		<?php include("inc.footer.php"); ?>

</div>
</body>
</html>
