<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>Tax Maintenance</title>
	
	<link rel="stylesheet" href="<?php echo base_url();?>/jqtransform/jqtransformplugin/jqtransform.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo base_url();?>/jqtransform/demo.css" type="text/css" media="all" />
	
</head>
<body id="dt_example">
	<div id="demo">
	<center>
	<h1>Tax Maintenance</h1>
		<table  align="center" class="display" cellpadding="10"  id="example"> 
			<tr>
				<th>Seq #</th>
				<th>Tax Status</th>
				<th>Description</th>
				<th>Exemption</th>
				<th colspan="1">Action</th>
			</tr>			<?php 
			$cnt=1;
			foreach($query as $row){
			
			if ($row->id==$edit)
			{?>
			<tr>
				<td><?php echo $cnt;?></td>
				<td><?php echo form_open('maintenance/taxupdate'); 
					 echo form_input('status',$row->status);?></td>
				<td><?php
				$data = array(
              'name'        => 'desc',
              'size'        => '70',
			  'value'        => $row->desc      );
					 echo form_input($data); ?></td>
				<td><?php 
					 echo form_input('ex',$row->exemption);echo "&nbsp";echo form_submit('mysubmit','Update'); ?></td>
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
				<td><?php echo $row->status;?></td>
				<td><?php echo $row->desc;?></td>
				<td><?php echo $row->exemption;?></td>
				<td>
				<?php
					echo form_open('maintenance/taxedit'); 
					echo form_hidden('id', $row->id);
					echo form_hidden('status', $row->status);
					echo form_hidden('desc', $row->desc);
					echo form_hidden('ex', $row->exemption);
					echo form_submit('mysubmit','Edit'); 
					echo form_close();
				?>
				</td>
				
			</tr>
			<?php }
			$cnt++;} ?>
		</table>
		<hr></hr>
		</center>
		<p>Enter a new tax status.</p><br/>
		<?php
			echo "Sequence no. ".$cnt."";
			echo form_open('maintenance/taxinsert'); 
			echo form_label('Tax Status:', 'status');
			echo form_input('status',"");
			echo form_label('Description:', 'desc');
			echo form_input('desc',"");
			echo form_label('Exemption:', 'ex');
			echo form_input('ex',"");
			echo form_submit('mysubmit','Insert'); 
			echo form_close();
		?>
	</div>
</body>
</html>