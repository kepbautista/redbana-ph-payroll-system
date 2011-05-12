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
	
		$(function(){
			$('form').jqTransform({imgPath:'<?php echo base_url();?>/jqtransform/jqtransformplugin/img/'});
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
			foreach($query as $row){
			
			if ($row->user_right==$edit)
			{?>
			<tr>
				<td><?php echo $cnt;?></td>
				<td><?php echo form_open('maintenance/userupdate'); 
					 echo form_input('user',$row->user_right);echo "&nbsp";echo form_submit('mysubmit','Update'); ?></td>
				<td>
				<?php
					echo form_hidden('id', $row->id);
					
					echo form_close();
				?>
				</td>
				<td>
				<?php
					echo form_open('maintenance/userdelete'); 
					echo form_hidden('id', $row->id);
					echo form_hidden('user', $row->user_right);
					echo form_submit('mysubmit','Delete'); 
					echo form_close();
				?>
				</td>

			</tr>
			<?php } else{?>
			<tr>
				<td><?php echo $cnt;?></td>
				<td><?php echo $row->user_right;?></td>
				<td>
				<?php
					echo form_open('maintenance/useredit'); 
					echo form_hidden('id', $row->id);
					echo form_hidden('user', $row->user_right);
					echo form_submit('mysubmit','Edit'); 
					echo form_close();
				?>
				</td>
				<td>
				<?php
					echo form_open('maintenance/userdelete'); 
					echo form_hidden('id', $row->id);
					echo form_hidden('user', $row->user_right);
					echo form_submit('mysubmit','Delete'); 
					echo form_close();
				?>
				</td>

			</tr>
			<?php }
			$cnt++;} ?>
		</table>
		<hr></hr>
		</center>
		<p>Enter the desired user right level.</p><br/>
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