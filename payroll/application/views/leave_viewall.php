
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
					<th>Date Filed</th> 
					<th>Start Date</th> 
					<th>Return Date</th> 
					<th>Type of Leave</th>
					<th>Reason for Leave</th>
					<th>Approval</th>
				</tr> 
			</thead> 
			<tbody> 
			<?php $cnt=1;$count=0;
			foreach ($query as $row)
			{ 
				if ($cnt%2==0)	$class="even";
				else	$class="odd";
				$emp=$row->empnum;
			?>
				<tr id="<?php echo $emp ?>" class="<?php echo $class ?>">
					<td><?php echo $emp; ?></td>
					<td><?php echo $row->filedate; ?></td>
					<td><?php echo $row->startdate; ?></td>
					<td><?php echo $row->returndate; ?></td>
					<td><?php echo $row->type; ?></td>
					<td><?php echo $row->reason; ?></td>
					<td><?php echo $row->approval; ?></td>
				</tr>
			<?php  
			$cnt++; 
			$count++;
			} ?>
			</tbody>
			<tfoot> 
				<tr> 
					<th>Employee Number</th> 
					<th>Date Filed</th> 
					<th>Start Date</th> 
					<th>Return Date</th> 
					<th>Type of Leave</th>
					<th>Reason for Leave</th>
					<th>Approval</th>
				</tr> 
			</tfoot>  
		</table>
	</div>
</body> 
</html>