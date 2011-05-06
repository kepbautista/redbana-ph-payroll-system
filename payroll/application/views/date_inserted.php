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
				$('form').jqTransform({imgPath:'<?php echo base_url();?>/jqtransform/jqtransformplugin/img/'});
			});
		</script>
</head>
<body id="dt_example">
<div id="demo">
	<h1><center>Record for This Day (<?php echo $month_s.'-'.$day_s.'-'.$year_s;?>)</center></h1>
	<h1 align="right"><a href="<?php echo base_url();?>/index.php/employee/viewtimesheet">View Record Today</a></h1>
			<?php if  (($trows==0))//If there are no records on the database with the date today,,it will output a button where the user can make a record today
			{
			echo "There are no records for today";
			echo form_open('Employee/Insertothertime');
			echo form_hidden('date',$date);
			echo form_submit('submits',"Make A Record for this date.");
			echo form_close();
			}
			else { ?><!-- It will output the table of records for the date today-->
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example"> 
					<thead> 
						<tr> 
							<th>Employee Number</th> 
							<th>Name</th> 
							<th>LOGIN</th> 
							<th>LOGOUT</th> 
							<th>DATE</th>
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
							<td><?php echo DATE("g:i:s a", STRTOTIME($row->login)) ?></td>
							<td><?php echo DATE("g:i:s a", STRTOTIME($row->logout)); ?></td>
							<td><?php echo $row->date; ?></td>
							<td>
							<?php
							echo form_open('employee/editTime'); 
							echo form_hidden('empnum', $emp);
							echo form_hidden('date', $row->date);
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
							<th>LOGIN</th> 
							<th>LOGOUT</th> 
							<th>DATE</th>
						</tr> 
					</tfoot>  
				</table>
			<?php }?>
			<!-- For Viewing Other dates-->
				<?php $yrs=range(2011,2050);
				$days=range(1,31);
				echo "<h1>View Time sheet for other date<h1>";
				echo form_open('employee/viewotherdate');//Once the user clicked view, it will redirect to employee/viewotherdate 
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