<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title> Edit PhilHealth Table </title>
<script type="text/javascript" src="system/application/views/jquery.columnhover.js"></script>
<script type="text/javascript" src="system/application/views/jquery.columnhover.pack.js"></script>
<link rel="stylesheet" type="text/css" href="system/application/views/style.css" media="screen"/>
<script type="text/javascript">

$(document).ready(function()
{
	$('#tableone').columnHover({eachCell:true, hoverClass:'betterhover'});
}
);
</script>

<style type="text/css">
table
{
	margin: 10px 50px;
	border: 1px solid gray;
	border-collapse: collapse;
	border-spacing: 0;
	text-align: center;	
}

thead
{
	background: #C0C0C0;
}

pre
{
	background-color: LemonChiffon;
	border: 1px solid gray;
}

td, th
{
	border: 1px solid gray;
}

td.betterhover, #tableone tbody tr:hover
{
	background: LightCyan;
}
</style>
</head>

<body>
<center>
<table id="tableone">
	<thead>
	<tr>
		<th rowspan="3"> Monthly <br /> Salary <br /> Bracket </th>
		<th rowspan="3" colspan="3">  Monthly Salary Range </th>
		<th rowspan="3" colspan="2"> Salary Base <br /> (SB) </th>
		<th rowspan="3" colspan="2"> Total Monthly <br /> Contributions </th>
		<th rowspan="3" colspan="2"> Employee Share <br /> (EeS) <br /> (EeS = 0.5 x TMC) </th>
		<th rowspan="3" colspan="2"> Employer Share <br /> (ErS) <br /> (ErS = 0.5 x TMC) </th>
	</tr>
	</thead>
<?php
	$cnt=1;
	foreach($query as $row){
?>	
		<?php if ($row->id == $edit)
		{?>
		<tr>
			<?php echo form_open('philhealth/update');echo form_hidden('hidden',$row->id);?> 
			<td><?php echo form_input('bracket',$row->bracket);?></td>
			<td colspan="1.5"><?php echo form_input('rangel',$row->rangel);?></td>
			<td colspan="1.5"><?php echo form_input('rangeh',$row->rangeh);?></td>
			<td colspan="3"><?php echo form_input('base',$row->base);?></td>
			<td colspan="2"><?php echo form_input('total',$row->total);?></td>
			<td colspan="2"><?php echo form_input('pes',$row->pes);?></td>
			<td colspan="2"><?php echo form_input('per',$row->per);?></td>
			<td><?php echo form_submit('mysubmit','Update');?></td>
			<td><?php echo form_close();?></td>
		</tr>
		<?php
		}
		else
		{?>
		<tr>		
			<td><?php echo $row->bracket; ?></td>
			<td colspan="3"><?php if ($cnt==$trows)echo $row->rangel." and up"; else echo $row->rangel." - ".$row->rangeh ?></td>
			<td><?php echo $row->base; ?></td>
			<td><?php echo $row->total; ?></td>
			<td><?php echo $row->pes; ?></td>
			<td><?php echo $row->per; ?></td>
		</tr>
		<?php 
		} 
		$cnt++;	
	}
?>
<tfoot></tfoot>
</table>
</body>
</center>
</html>