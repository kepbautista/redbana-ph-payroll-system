<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
	<head> 
		
		<title>View All Leaves</title> 
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
	
		 <div id="demo">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example"> 
			<thead> 
				<tr> 
				<th>Employee Number</th> 
				<th>Employee Name</th>
				<th>Start Date of Leave</th>
				<th>Return Date to Work</th>
				<th>Leave Status</th>
				</tr> 
			</thead> 
			<tbody> 
			<?php $cnt=1;$count=0;
			foreach ($query as $row)
			{
				if($row->dept == $dept){
				if ($cnt%2==0)	$class="even";
				else	$class="odd";
				$emp=$row->empnum;
			?>
				<tr id="<?php echo $emp ?>" class="<?php echo $class ?>">
					<td><?php echo $emp; ?></td>
					<td><?php echo $row->fname; echo " "; echo $row->mname; echo " "; echo $row->sname; ?></td>
					<td><?php echo $row->startdate ?></td>
					<td><?php echo $row->returndate ?></td>
					<td><?php echo $row->approval ?></td>
					<td>
						<?php
						$hidden=$row->empnum;
						$hidden2=$row->filedate;
						echo form_open('leave/approve'); 
						echo form_hidden('empnum', $emp);
						echo form_hidden('filedate', $hidden2);
						echo form_submit('editEmp','View'); 
						echo form_close(); 
						?>
					</td>
				</tr>
			<?php  
			$cnt++; 
			$count++;
				}
			}?>
			</tbody>
			<tfoot> 
				<tr> 
					<th>Employee Number</th> 
					<th>Employee Name</th> 		
				<th>Start Date of Leave</th>
				<th>Return Date to Work</th>
				<th>Leave Status</th>					
				</tr> 
			</tfoot>  
		</table>
	</div>
</body> 
</html>