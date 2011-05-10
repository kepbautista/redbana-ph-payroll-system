<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SSS Table</title>
<script type="text/javascript" src="<?php echo base_url();?>devtools/jquery-1.5.2"></script>
<script type="text/javascript" src="<?php echo base_url()?>/js/jquery.columnhover.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/js/jquery.columnhover.pack.js"></script>
<link rel="stylesheet" type="text/css" href="/cody/style.css" media="screen"/>
<script type="text/javascript">
$(document).ready(function()
{
	$('#tabletwo').columnHover({eachCell:true, hoverClass:'betterhover'});
});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#addView').hide();
		$('#add').click(function(){
			$.post("<?php echo base_url();?>devtools/insertBrackets.php", {
             N: $('#brackets').val(),
			 tableType: "sss",
          },
          function(data){
                $("#insertView").html(data);
				$("#sss_table").fadeOut();
				$('#addView').fadeIn();
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
#insert{
 position:absolute;
 top:0;
 right:0;
 width:200px;
}
#sss_tables{
 position:absolute;
 top:0;
 left:0;
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
<div name="sss_table" id="sss_table">
<table id="tabletwo">
	<thead>
	<tr>
		<th colspan="2" rowspan="3"> Range <br /> of <br /> Compensation </th>
		<th rowspan="3"> Monthly <br /> Salary <br /> Credit </th>
		<th colspan="7"> EMPLOYER-EMPLOYEE </th>
		<th> SE/VM/OFW </th>
		<th rowspan="3" colspan="2"> Edit </th>
		<tr>
		<th colspan="3"> SOCIAL SECURITY </th>
		<th> EC </th>
		<th colspan="3"> TOTAL CONTRIBUTION </th>
		<th rowspan="2"> TOTAL <br /> CONTRIBUTION </th>
		</tr>
		<tr>
		<th> ER </th>
		<th> EE </th>
		<th> Total </th>
		<th> EC </th>
		<th> ER </th>
		<th> EE </th>
		<th> Total </th>
		</tr>
	</tr>
	</thead>
<?php
	$cnt=1;
	foreach ($query as $row){
?>	
	<tr>
		<td colspan="2"><?php if ($cnt==$trows)echo $row->rangel." - over"; else echo $row->rangel." - ".$row->rangeh; ?></td>
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
</div>

<div id="insert" name="insert">
	<h4>Insert Brackets</h4><br/>
	How many brackets to insert?&nbsp&nbsp
	<input type="text" name="brackets" id="brackets" class="numeric" size="4"/>
	<input type="button" name="add" id="add" value="Add" />
	<span style="color:red;"><?php if(isset($message)) echo $message;?></span>
</div>
<div name="addView" id="addView">
<form name="insertBrackets" method="post"  accept-charset="utf-8" action="<?php echo site_url()?>/sss/insert">
<span name="insertView" id="insertView">
</form>
</div>
</body>
</center>
</html>