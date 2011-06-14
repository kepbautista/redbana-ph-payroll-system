<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>History Table </title>
	
		<link href="<?php echo base_url(); ?>assets/css/mainstyling.css" rel="stylesheet" type="text/css" />
		<!-- For DATATABLES-->
		<link href="<?php echo base_url(); ?>assets/css/mainstyling.css" rel="stylesheet" type="text/css" />
		<style type="text/css" title="currentStyle"> 
			@import "<?php echo base_url();?>/css/demo_page.css";
			@import "<?php echo base_url();?>/css/demo_table.css";
		</style> 
		<script type="text/javascript" language="javascript" src="<?php echo base_url();?>/js/jquery.js"></script> 
		<script type="text/javascript" language="javascript" src="<?php echo base_url();?>/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8"> 
			$(document).ready( function() {
				$('#example').dataTable({
					/* Disable initial sort */
					"aaSorting": [],
					"iDisplayLength": 100
				});
			})
		</script> 
	</head>
<body id="dt_example">
<div id="demo">
	
			<?php if  (($trows==0))//If there are no records on the database with the date today,,it will output a button where the user can make a record today
			{
				echo "<p>There are no activities yet.</p><br/>";
			}
			else { ?><!-- It will output the table of records for the date today-->
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example"> 
					<thead> 
						<tr> 
							<th>Date</th> 
							<th>Activities</th>	
						</tr> 
					</thead> 
					<tbody> 
					<?php 
					$cnt=1;
					foreach ($query->result() as $row)
					{ 
					$rowdate=$row->date;
					?>
						<tr>
							<td><?php echo $row->date; ?></td>
							<td>
								<?php 
								if ($row->table=="employee")
								{
									if ($row->action=="insert") 
										echo $row->user.' inserted '.$row->person.' on the list of employees.';
									else if ($row->action=="update")
									{
										echo $row->user.' changed the '.$row->data.' of '.$row->person;
									}
									else 
										echo $row->user.' deleted '.$row->person.' on the list of employees.';
								}
								else if ($row->table=="user_main")
								{
									if ($row->action=="insert") 
										echo $row->user.' inserted '.$row->person.' on the list of user rights.';
									else if ($row->action=="update")
										echo $row->user.' updated the user right '.$row->person;
									else 
										echo $row->user.' deleted '.$row->person.' on the list of user rights.';
								}
								else if ($row->table=="dept_main")
								{
									if ($row->action=="insert") 
										echo $row->user.' inserted '.$row->person.' on the list of departments.';
									else if ($row->action=="update")
										echo $row->user.' updated the department '.$row->person;
									else 
										echo $row->user.' deleted '.$row->person.' on the list of departments.';
								}
								else if ($row->table=="pos_main")
								{
									if ($row->action=="insert") 
										echo $row->user.' inserted '.$row->person.' on the list of positions.';
									else if ($row->action=="update")
										echo $row->user.' updated the position '.$row->person;
									else 
										echo $row->user.' deleted '.$row->person.' on the list of positions.';
								}
								else if ($row->table=="tax_status")
								{
									if ($row->action=="insert") 
										echo $row->user.' inserted '.$row->person.' on the list of tax status.';
									else if ($row->action=="update")
										echo $row->user.' updated the tax status '.$row->person;
									else 
										echo $row->user.' deleted '.$row->person.' on the list of tax status.';
								}
								else if ($row->table=="emp_type")
								{
									if ($row->action=="insert") 
										echo $row->user.' inserted '.$row->person.' on the list of employment type.';
									else if ($row->action=="update")
										echo $row->user.' updated the employment type '.$row->person;
									else 
										echo $row->user.' deleted '.$row->person.' on the list of employment type.';
								}
								else if ($row->table=="payment_mode")
								{
									if ($row->action=="insert") 
										echo $row->user.' inserted '.$row->person.' on the list of payment mode.';
									else if ($row->action=="update")
										echo $row->user.' updated the payment mode '.$row->person;
									else 
										echo $row->user.' deleted '.$row->person.' on the list of payment mode.';
								}
								else if ($row->table=="daily_desc")
								{
									if ($row->action=="insert") 
										echo $row->user.' inserted '.$row->person.' on the list of daily description.';
									else if ($row->action=="update")
										echo $row->user.' updated the daily description '.$row->person;
									else 
										echo $row->user.' deleted '.$row->person.' on the list of daily description.';
								}
								else if ($row->table=="philhealth")
								{
									if ($row->action=="insert") 
										echo $row->user.' inserted the bracket '.$row->person.' on the Philhealth Table.';
									else if ($row->action=="update")
										echo $row->user.' updated the bracket '.$row->person.' on the Philhealth Table.';
									else 
										echo $row->user.' deleted the bracket '.$row->person.' on the Philhealth Table.';
								}
								else if ($row->table=="sss")
								{
									if ($row->action=="insert") 
										echo $row->user.' inserted the bracket'.$row->person.' on the SSS Table.';
									else if ($row->action=="update")
										echo $row->user.' updated the bracket '.$row->person;
									else 
										echo $row->user.' deleted the bracket '.$row->person.' on the SSS Table.';
								}
								else if ($row->table=="withholding_tax")
								{
									if ($row->action=="insert") 
										echo $row->user.' inserted '.$row->person.' on the Withholding Tax Table.';
									else if ($row->action=="update")
										echo $row->user.' updated the bracket '.$row->person;
									else 
										echo $row->user.' deleted '.$row->person.' on the Withholding Tax Table.';
								}
								else
								{
									if ($row->action=="insert") 
										echo $row->user.' inserted '.$row->person.' on the list of employee.';
									else if ($row->action=="update")
										echo $row->user.' updated the profile of '.$row->person;
									else 
										echo $row->user.' deleted '.$row->person.' on the list of employee.';
								}
								?>
							</td>
						</tr>
					<?php 
					$cnt++; 
					} ?>
					</tbody>  
					<tfoot> 
						<tr> 
							<th>Date</th> 
							<th>Activities</th>	
						</tr> 
					</tfoot> 
				</table>
			<?php }?>
</div>
</body>
</html>