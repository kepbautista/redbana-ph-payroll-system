<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>Employment Maintenance</title>
	
	<link rel="stylesheet" href="<?php echo base_url();?>/jqtransform/jqtransformplugin/jqtransform.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo base_url();?>/jqtransform/demo.css" type="text/css" media="all" />
	
	<script type="text/javascript" src="<?php echo base_url();?>/jqtransform/requiered/jquery.js" ></script>
	<script type="text/javascript" src="<?php echo base_url();?>/jqtransform/jqtransformplugin/jquery.jqtransform.js" ></script>
	<script language="javascript">
		$(document).ready(function(){
			$("button").click(function(){
			var r = confirm("Are you sure you want to delete this bracket?");
				if(r==true){
					$.post("<?php echo base_url();?>devtools/deleteBrackets.php", {
						query: $(this).val(),
						tableType: "emp_type",
						person: "<?php echo $person; ?>",
				},//perform ajax to delete the bracket using mysql_query
				function(data){
					alert("Bracket deleted! ");
					window.location.href = "<?php echo site_url();?>"+"/maintenance/typeview";//reload page to see the effect of delete
				});
				}
					else alert("Bracket delete cancelled!");
			});
		});
	</script>
</head>
<body id="dt_example">
	<div id="demo">
	<center>
	<h1>Employment Maintenance</h1>
		<table  align="center" class="display" cellpadding="10"  id="example"> 
			<tr>
				<th>Seq #</th>
				<th>Employee Type</th>
				<th colspan="2">Action</th>
			</tr>
			<?php 
			$cnt=1;
			foreach($query as $row){?>
			<tr>
				<td><?php echo $cnt;?></td>
				<td><?php echo strtoupper($row->type);?></td>
				<td>
				<?php
					echo form_open('maintenance/typeedit'); 
					echo form_hidden('id', $row->id);
					echo form_hidden('type', $row->type);
					echo form_submit('mysubmit','Edit'); 
					echo form_close();
				?>
				</td>
				<td>
				<?php
					echo form_open('maintenance/typedelete'); 
					echo form_hidden('id', $row->id);
					echo form_hidden('type', $row->type);
					echo "<button type='button' name='delete' id='delete' value='".$row->id."'>Delete</button>"; 
					echo form_close();
				?>
				</td>

			</tr>
			<?php 
			$cnt++;} ?>
		</table>
		<hr></hr>
		</center>
		<p>Enter the desired employment type.</p><br/>
		<?php
			echo "Sequence no. ".$cnt."";
			echo form_open('maintenance/typeinsert'); 
			echo form_input('type',"");
			echo form_submit('mysubmit','Insert'); 
			echo form_close();
			echo "<span style='color:red; text-align:center'>"
				 .validation_errors()."</span>";
		?>
	</div>
</body>
</html>
</html>