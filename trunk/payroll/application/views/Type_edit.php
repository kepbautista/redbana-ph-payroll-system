<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>Employment Maintenance</title>
	
	<link rel="stylesheet" href="<?php echo base_url();?>/jqtransform/jqtransformplugin/jqtransform.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo base_url();?>/jqtransform/demo.css" type="text/css" media="all" />
	
</head>
<body id="dt_example">
	<div id="demo">
	<center>
	<h1>Employment Maintenance</h1>
		<table  align="center" class="display" cellpadding="10"  id="example"> 
			<tr>
				<th>Seq #</th>
				<th>Employee Type</th>
				<th>Action</th>
			</tr>
			<?php 
			$cnt=1;
			foreach($query as $row){
			
			if ($row->type==$edit)
			{?>
			<tr>
				<td><?php echo $cnt;?></td>
				<td><?php echo form_open('maintenance/typeupdate'); 
					 echo form_input('type',$row->type);echo "&nbsp";echo form_submit('mysubmit','Update'); ?></td>
				<td>
				<?php
					echo form_hidden('id', $row->id);
					echo form_close();
				?>
				</td>
			</tr>
			<?php } else{?>
			<tr>
				<td><?php echo $cnt;?></td>
				<td><?php echo strtoupper($row->type);?></td>
				<td>
				<?php
					echo form_open('maintenance/typeedit'); 
					echo form_hidden('id', $row->id);
					echo form_hidden('type', $row->type);
					echo form_submit('mysubmit','Update'); 
					echo form_close();
				?>
				</td>
				<td>

			</tr>
			<?php }
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
		?>
	</div>
</body>
</html>