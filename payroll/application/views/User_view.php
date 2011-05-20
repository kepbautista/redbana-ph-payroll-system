<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>User Right Maintenance</title>
	
	<link rel="stylesheet" href="<?php echo base_url();?>/jqtransform/jqtransformplugin/jqtransform.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo base_url();?>/jqtransform/demo.css" type="text/css" media="all" />
	
	<script type="text/javascript" src="<?php echo base_url();?>/jqtransform/requiered/jquery.js" ></script>
	<script type="text/javascript" src="<?php echo base_url();?>/jqtransform/jqtransformplugin/jquery.jqtransform.js" ></script>
	<script language="javascript">
		$(document).ready(function(){
			$("button").click(function(){
			var r = confirm("Are you sure you want to delete this bracket?");
				if(r==true){ //alert($(this).val());
					$.post("<?php echo base_url();?>devtools/deleteBrackets.php", {
						query: $(this).val(),
						tableType: "user_main",
				},//perform ajax to delete the bracket using mysql_query
				function(data){
					alert("Bracket deleted! ");
					window.location.href = "<?php echo site_url();?>"+"/maintenance/userview";//reload page to see the effect of delete
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
	<h1>User Right Maintenance</h1>
		<table  align="center" class="display" cellpadding="10"  id="example"> 
			<tr>
				<th>Seq #</th>
				<th>User Right</th>
				<th colspan="2">Action</th>
			</tr>
			<?php 
			$cnt=1;
			foreach($query as $row){?>
			<tr>
				<td><?php echo $cnt;?></td>
				<td><?php echo $row->user_right;?></td>
				<td>
				<?php
					echo form_open('maintenance/useredit'); 
					echo form_hidden('user', $row->user_right);
					echo form_submit('mysubmit','Edit'); 
					echo form_close();
				?>
				</td>
				<td>
				<?php
					echo form_open('maintenance/userdelete'); 
					echo form_hidden('user_right', $row->user_right);
					echo "<button type='button' name='delete' id='delete' value='".$row->user_right."'>Delete</button>";
					echo form_close();
				?>
				</td>
			</tr>
			<?php 
			$cnt++;} ?>
		</table>
		<hr></hr>
		</center>
		<p>Enter an applicable user right.</p><br/>
		<?php
			echo "Sequence no. ".$cnt."";
			echo form_open('maintenance/userinsert'); 
			echo form_input('user',"");
			echo form_submit('mysubmit','Insert'); 
			echo form_close();
		?>
	</div>
</body>
</html>