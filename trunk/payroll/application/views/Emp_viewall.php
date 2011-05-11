
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
	<head> 
		
		<title>View All Employee</title> 
		<style type="text/css" title="currentStyle"> 
			@import "<?php echo base_url();?>/css/demo_page.css";
			@import "<?php echo base_url();?>/css/demo_table.css";
		</style> 
		<script type="text/javascript" language="javascript" src="<?php echo base_url();?>/js/jquery.js"></script> 
		<script type="text/javascript" language="javascript" src="<?php echo base_url();?>/css/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8"> 
			$(document).ready(function() {
				$('#example').dataTable();
			} );
		</script> 
	</head> 
	<body id="dt_example"> <center>
	<?php  include  ("links.php");?>
		 <div id="demo">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example"> 
			<thead> 
				<tr> 
					<th>Seq #</th> 
					<th>Employee</th> 
					<th>Emp No.</th> 
					<th>Department</th> 
					<th>Position</th>
					<th>Type</th>
					<th>Salary</th>
					<th>Status</th>
				</tr> 
			</thead> 
			<tbody> 
			<?php $cnt=1;$count=0;
			foreach ($query as $row)
			{ 
				if ($cnt%2==0)	$class="even";
				else	$class="odd";
				$name= $row->title.' '.$row->fname.' '.$row->mname.' '.$row->sname.'.';
				$emp=$row->empnum;
			?>
				<tr id="<?php echo $cnt ?>" class="<?php echo $class ?>">
					<td><?php echo $cnt; ?></td>
					<td><?php echo $name; ?></td>
					<td><?php echo $emp; ?></td>
					<td><?php echo $row->dept; ?></td>
					<td><?php echo $row->position; ?></td>
					<td><?php echo $row->emp_type; ?></td>
					<td><?php echo $row->mrate; ?></td>
					<td><?php echo $row->emp_status; ?></td>
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
					<th>Seq #</th> 
					<th>Employee</th> 
					<th>Emp No.</th> 
					<th>Department</th> 
					<th>Position</th>
					<th>Type</th>
					<th>Salary</th>
					<th>Status</th>
				</tr> 
			</tfoot>  
		</table>
	</div></center>
</body> 
</html>