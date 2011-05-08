
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
	<head> 
		
		<title>View All Employee</title> 
		<style type="text/css" title="currentStyle"> 
			@import "<?php echo base_url();?>/css/demo_page.css";
			@import "<?php echo base_url();?>/css/demo_table.css";
		</style> 
		<script type="text/javascript" language="javascript" src="<?php echo base_url();?>/js/jquery.js"></script> 
		<script type="text/javascript" language="javascript" src="<?php echo base_url();?>/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8"> 
			$(document).ready(function() {
				$('#example').dataTable();
			} );
		</script> 
	</head> 
	<body id="dt_example"> 
	<?php  include  ("links.php");?>
		 <div id="demo">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example"> 
			<thead> 
				<tr> 
					<th>Employee Number</th> 
					<th>Name</th> 
					<th>Birth Date</th> 
					<th>Start Date</th> 
					<th>Gender</th>
					<th>Position</th>
					<th>Department</th>
					<th>Payment Mode</th>
					<th>Monthly Rate</th>
					<th>Status</th>
					<th>Password</th>
				</tr> 
			</thead> 
			<tbody> 
			<?php $cnt=1;$count=0;
			foreach ($query as $row)
			{ 
				if ($cnt%2==0)	$class="even";
				else	$class="odd";
				$name= $row->sname.', '.$row->fname.', '.$row->mname.'.';
				$emp=$row->empnum;
			?>
				<tr id="<?php echo $emp ?>" class="<?php echo $class ?>">
					<td><?php echo $emp; ?></td>
					<td><?php echo $name; ?></td>
					<td><?php echo $row->bdate; ?></td>
					<td><?php echo $row->sdate; ?></td>
					<td><?php echo $row->gender; ?></td>
					<td><?php echo $row->position; ?></td>
					<td><?php echo $row->dept; ?></td>
					<td><?php echo $row->payment_mode; ?></td>
					<td><?php echo $row->mrate; ?></td>
					<td><?php echo $row->desc; $cnt++;?></td>
					<td><?php echo $row->password; ?></td>
					<td>
						<?php
						$hidden=$row->empnum;
						echo form_open('employee/edit'); 
						echo form_hidden('empnum', $emp);
						echo form_submit('editEmp','Edit!'); 
						echo form_close(); 
						echo form_open('employee/delete'); 
						echo form_hidden('empnum', $hidden);
						echo form_submit('mysubmit','Delete!'); 
						echo form_close(); 
						
						?>
					</td>
				</tr>
			<?php  
			$cnt++; 
			$count++;
			} ?>
			</tbody>
			<tfoot> 
				<tr> 
					<th>Employee Number</th> 
					<th>Name</th> 
					<th>Birth Date</th> 
					<th>Start Date</th> 
					<th>Gender</th>
					<th>Position</th>
					<th>Department</th>
					<th>Payment Mode</th>
					<th>Monthly Rate</th>
					<th>Status</th>
					<th>Password</th>
				</tr> 
			</tfoot>  
		</table>
	</div>
</body> 
</html>