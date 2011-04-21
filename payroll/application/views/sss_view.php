<html>
<title>SSS Table</title>
<head>
<script type="text/javascript" src="jquery.columnhover.js"></script>
<script type="text/javascript" src="jquery.columnhover.pack.js "></script>
<script type="text/javascript">

$(document).ready(function()

{
	$('#tabletwo').columnHover({eachCell:true, hoverClass:'betterhover'});

});

</script>
<style type="text/css">
table
{
	margin: 10px 50px;
	border: 1px solid gray;
	border-collapse: collapse;
	border-spacing: 0;
	text-align: center;
	
}thead
{
	background: bisque;
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
td.betterhover, #tabletwo tbody tr:hover
{
	background: LightCyan;
}
</style>
</head>
<body>
<center>
<table id="tabletwo">
	<thead>
	<tr>
		<th colspan="2" rowspan="3">Range<br/> of<br/> Compensation</th>
		<th rowspan="3"> Monthly<br/> Salary<br/> Credit</th>
		<th colspan="7">EMPLOYER-EMPLOYEE</th>
		<th >SE/VM/OFW</th>
		<tr>
		<th colspan="3">SOCIAL SECURITY</th>
		<th >EC</th>
		<th colspan="3">TOTAL CONTRIBUTION</th>
		<th rowspan="2">TOTAL<br/>CONTRIBUTION</th>
		</tr>
		<tr>
		<th>ER</th>
		<th>EE</th>
		<th>Total</th>
		<th>EC</th>
		<th>ER</th>
		<th>EE</th>
		<th>Total</th>
		</tr>
	</tr>
	</thead>
<?php
	$cnt=1;
	 //if ($cnt==$trows)echo "over"; else echo $row->rangeh; 
	foreach ($query as $row){
?>	
	<tr>
		<td colspan="2"><?php if ($cnt==$trows)echo $row->rangel."-over"; else echo $row->rangel."-".$row->rangeh; ?></td>
		<td><?php echo $row->msc; ?></td>
		<td><?php echo $row->ser; ?></td>
		<td><?php echo $row->see; ?></td>
		<td><?php echo $row->stotal; ?></td>
		<td><?php echo $row->ecer; ?></td>
		<td><?php echo $row->ter; ?></td>
		<td><?php echo $row->tee; ?></td>
		<td><?php echo $row->ttotal; ?></td>
		<td><?php echo $row->totalcont; $cnt++;?></td>
		<td>
		
		<?php
			$hidden=$row->id;
			echo form_open('sss/edit'); 
			echo form_hidden('hidden', $hidden);
			echo form_submit('mysubmit','Edit!'); 
			echo form_close(); 
		?></td>

	</tr>
<?php
	}
?>
<tfoot></tfoot>
</table>
</body>
</center>
</html>