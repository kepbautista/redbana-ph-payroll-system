<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>View Record </title>
		<!-- For DATATABLES-->
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
		<!-- For JQTRANSFORM-->
		<link rel="stylesheet" href="<?php echo base_url();?>/jqtransform/jqtransformplugin/jqtransform.css" type="text/css" media="all" />
		<script type="text/javascript" src="<?php echo base_url();?>/jqtransform/jqtransformplugin/jquery.jqtransform.js" ></script>
		<script language="javascript">
			$(function(){
				$('form').jqTransform({imgPath:'<?php echo base_url();?>jqtransform/jqtransformplugin/img/'});
			});
		</script>
</head>
<body id="dt_example">
<div id="demo">
	<h1><center><?php echo date('M d, Y', strtotime($year_s.'-'.$month_s.'-'.$day_s));?></center></h1>
	<h1 align="right"><a href="<?php echo base_url();?>/index.php/employee/viewtimesheet">View Record Today</a></h1>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example"> 
					<thead> 
						<tr> 
							<th>Employee Number</th> 
							<th>Name</th> 
							<th>Date of Time-in</th> 
							<th>Time-in</th> 
							<th>Date of Time-out</th>
							<th>Time-out</th>
						</tr> 
					</thead> 
					<tbody> 
					<?php 
					$cnt=1;
					foreach ($query as $row)
					{ 
						if ($cnt%2==0)	
							$class="even";//identifies the 'td' class for css styling
						else	
							$class="odd";
					$name= $row->sname.', '.$row->fname.', '.$row->mname.'.';
					$emp=$row->empnum;?>
						<tr id="<?php echo $emp ?>" class="<?php echo $class ?>">
							<td><?php echo $emp; ?></td>
							<td><?php echo $name; ?></td>
							<td><?php echo date('M d, Y', strtotime($row->date_in)); ?></td>
							<td><?php echo $row->time_in; ?></td>
							<td><?php echo date('M d, Y', strtotime($row->date_out)); ?></td>
							<td><?php echo $row->time_out; ?></td>
							<td>
							<?php
							echo form_open('timesheet/editTime'); 
							echo form_hidden('empnum', $emp);
							echo form_hidden('date', $row->date_in);
							echo form_submit('mysubmit','Edit'); 
							echo form_close(); 
							?>
							</td>
						</tr>
					<?php 
					$cnt++; 
					} ?>
					</tbody>
					<tfoot> 
						<tr> 
							<th>Employee Number</th> 
							<th>Name</th> 
							<th>Date of Time-in</th> 
							<th>Time-in</th> 
							<th>Date of Time-out</th>
							<th>Time-out</th>
						</tr> 
					</tfoot>  
				</table>
			
			
			<!-- For Viewing Other dates-->
				<?php $yrs=range(2011,2050);
				$days=range(1,31);
				echo "<h1>View Time sheet for other date<h1>";
				echo form_open('timesheet/viewotherdate');//Once the user clicked view, it will redirect to employee/viewotherdate 
				echo form_dropdown('mos', $mos,$month_s);//make dropdown for months
				?>
				<p>
				<select name="days" id="select"><!-- Make drodown for days-->
				<?php
				foreach ($days as $value) 
				{ 
					if ($value==$day_s)echo '<option value="'.$value.'" SELECTED>'.$value.'</option>\n'; 
					else echo '<option value="'.$value.'">'.$value.'</option>\n'; 
				}
				?>
				</select>
				<select name="yrs" id="select"><!-- Make drodown for months-->
				<?php
				foreach ($yrs as $value) { 
				if ($value==$year_s)echo '<option value="'.$value.'" SELECTED>'.$value.'</option>\n'; 
				else echo '<option value="'.$value.'">'.$value.'</option>\n'; 
				}
				?>
				</select>
				<?php echo form_submit('mysubmit','View!'); 
				echo form_close(); ?>
</div>
</body>
</html>