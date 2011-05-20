<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title> PhilHealth Table </title>
<script type="text/javascript" src="<?php echo base_url();?>devtools/jquery-1.5.2"></script>
<script type="text/javascript" src="<?php echo base_url()?>/js/jquery.columnhover.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/js/jquery.columnhover.pack.js"></script>
<link rel="stylesheet" type="text/css" href="/cody/style.css" media="screen"/>
<script type="text/javascript">

$(document).ready(function()
{
	$('#tableone').columnHover({eachCell:true, hoverClass:'betterhover'});
}
);
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$("button").click(function(){
		var r = confirm(("Are you sure you want to delete this bracket?");
			if(r==true){
				$.post("<?php echo base_url();?>devtools/deleteBrackets.php", {
					query: $(this).val(),
					tableType: "philhealth",
				},	// perform ajax here to delete the bracket (row) using mysql_query
				function(data){
					alert("Bracket deleted! ");
					window.location.href = "<?php echo site_url();?>"+"/philhealth/getall";	// reload page to see the effect of the deleted bracket (row)
				});
			}
			else alert("Bracket delete cancelled!");
		});
		$('#addView').hide();
		$('#add').click(function(){
			$.post("<?php echo base_url();?>devtools/insertPHBrackets.php", {
			N: $('#brackets').val(),
			tableType: "philhealth",
		},
		function(data){
			$("#insertView").html(data);
			$("#philhealth_table").fadeOut();
			$('#addView').fadeOut();
			$('#addView').slideDown();
		}
		);
	});
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
#insert{
	position:absolute;
	top:0;
	right:0;
	width:200px;
}
#philhealth_tables{
	position:absolute;
	top:0;
	left:0
	width:200px;
}
.numeric{
background-color: #87CEEB;
color: navy;
}
</style>
</head>

<body>
<center>
<div name="philhealth_table" id="philhealth_table">
<table id="tableone">
	<thead>
	<tr>
		<th rowspan="3"> Monthly <br /> Salary <br /> Bracket </th>
		<th rowspan="3" colspan="3">c  Monthly Salary Range </th>
		<th rowspan="3" colspan="2"> Salary Base <br /> (SB) </th>
		<th rowspan="3" colspan="2"> Total Monthly <br /> Contributions </th>
		<th rowspan="3" colspan="2"> Employee Share <br /> (EeS) <br /> (EeS = 0.5 x TMC) </th>
		<th rowspan="3" colspan="2"> Employer Share <br /> (ErS) <br /> (ErS = 0.5 x TMC) </th>
		<th rowspan="3" colspan="2"> Modify Brackets </th>
	</tr>
	</thead>

<?php
	$cnt=1;
	foreach ($query as $row){
?>
	<tr>
		<td><?php echo $row->bracket; ?></td>
		<td colspan="3"><?php if ($cnt==$trows)echo $row->rangel." and up"; else echo $row->rangel." - ".$row->rangeh ?></td>
		<td colspan="2"><?php echo $row->base; ?></td>
		<td colspan="2"><?php echo $row->total; ?></td>
		<td colspan="2"><?php echo $row->pes; ?></td>
		<td colspan="2"><?php echo $row->per; ?></td>
		
		<td>
		<?php
			$hidden=$row->id;
			echo form_open('philhealth/edit'); 
			echo form_hidden('hidden', $hidden);
			echo form_submit('mysubmit','Edit');
			echo "<button type='button' name='delete' id='delete' value='".$row->id."'>Delete</button>";
			echo form_close(); 
		?></td>
	</tr>
<?php
	}
?>
<tfoot></tfoot>
</table>
</div>

<div id="insert" name="insert">
	<h4> Insert Brackets </h4> <br />
	How many brackets to insert?&nbsp&nbsp
	<input type="text" name="brackets" id="brackets" class="numeric" size="4"/>
	<input type="button" name="add" id="add" value="Add"/>
	<span style="color:red;"><?php if(isset($message)) echo $message;?></span>
</div>

<div name="addView" id="addView">
<form name="insertPHBrackets" method="post" accept-charset="utf-8" action="<?php echo site_url()?>/philhealth/insert">
<span name="insertView" id="insertView">
</form>
</div>
</body>
</center>
</html>