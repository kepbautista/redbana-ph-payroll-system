<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>PHILHEALTH Table</title> 
<script type="text/javascript" src="<?php echo base_url()?>/js/jquery.columnhover.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/js/jquery.columnhover.pack.js "></script>
<link rel="stylesheet" type="text/css" href="/cody/style.css" media="screen" />
<script type="text/javascript">

$(document).ready(function(){
	$('#tableone').columnHover({eachCell:true, hoverClass:'betterhover'});
});

</script>
<style type="text/css">
table{
	margin: 10px 50px;
	border: 1px solid gray;
	border-collapse: collapse;
	border-spacing: 0;
	text-align: center;
}

thead{
	background: bisque;
}

pes{
	background-color: LemonChiffon;
	border: 1px solid gray;
}

td, th{
	border: 1px solid gray;
}

td.betterhover, #tableone tbody tr:hover{
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
		
<!--
<div id="page">
	<?php 
				echo "<a class = 'active' href = 'login/logout' id = 'cname' alignment = 'left' > Sign out </a>";
				
	?>	
	<div id="contentarea">
		<br /> <br />
		<table id="tab" bordercolor="#9ac1c9" border="5">
				<tr id="tr_header">
				<th id="10">bracket</th>
				<th id="40">rangel</th>
				<th id="10">rangeh</th>
				<th id="10">base</th>
				<th id="10">total</th>
				<th id="10">pes</th>
				<th id="10">per</th>
				</tr>
				
				<!-- dynamic table for philhealth -->		
	<?php
	/*
				echo form_open('philhealth');
				$n=0;
				foreach($result->result_array() as $entry):
					if($result == NULL){echo "null";}else{
					if($n%2==0){
						echo"<tr id=\"row1\" > "; 
					}else{
						echo"<tr id=\"row2\" > "; 
					}$n++;
					
					echo"<th id=\"10\">";
					echo $entry['bracket'];
					echo"</th>";
					echo"<th id=\"40\">";
					echo $entry['rangel'];
					echo"</th>";
					echo "<td id=\"10\">";
					echo $entry['rangeh'];
					echo"</td>";
					echo "<td id=\"10\">";
					echo $entry['base'];
					echo"</td>";
					echo "<td id=\"10\">";
					echo $entry['total'];
					echo"</td>";
					echo "<td id=\"10\">";
					echo $entry['pes'];
					echo"</td>";
					echo "<td id=\"10\">";
					echo $entry['per'];
					echo"</td>";
					echo "</tr>";
					}
				
				 endforeach;
					echo "</table>";
					echo form_close();
*/
	?>
<!--	
	</div>

	<div id="footer">
	</div>
-->	

<?php
	$cnt=2;
	foreach ($query as $row){
?>
	<tr>
		<td colspan="3"><?php if ($cnt==$trows)echo $row->rangel."and below"; else echo $row->rangel."to".$row->rangeh ?></td>
		<td colspan="3"><?php if ($cnt==$trows)echo $row->rangel."and up"; else echo $row->rangel."to".$row->rangeh; ?></td>
		<td><?php echo $row->bracket; ?></td>
		<td><?php echo $row->base; ?></td>
		<td><?php echo $row->total; ?></td>
		<td><?php echo $row->pes; ?></td>
		<td><?php echo $row->per; ?></td>
		<td>
		<?php
			$hidden=$row->id;
			echo form_open('philhealth/edit'); 
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