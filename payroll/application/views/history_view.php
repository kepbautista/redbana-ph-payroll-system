<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>History Table </title>
	
		<link href="<?php echo base_url(); ?>assets/css/mainstyling.css" rel="stylesheet" type="text/css" />
		<!-- For DATATABLES-->
		<style type="text/css" title="currentStyle"> 
			@import "<?php echo base_url();?>/css/demo_page.css";
			@import "<?php echo base_url();?>/css/demo_table.css";
		</style> 
		<!-- For JQTRANSFORM-->
		<link rel="stylesheet" href="<?php echo base_url();?>/jqtransform/jqtransformplugin/jqtransform.css" type="text/css" media="all" />
		<script type="text/javascript" src="<?php echo base_url();?>/jqtransform/jqtransformplugin/jquery.jqtransform.js" ></script>
		<script type="text/javascript" >
			$(function(){
				$('form').jqTransform({imgPath:'<?php echo base_url();?>/jqtransform/jqtransformplugin/img/'});
			});
		</script>
</head>
<body id="dt_example">
<div id="demo">
	
			<?php if  (($trows==0))//If there are no records on the database with the date today,,it will output a button where the user can make a record today
			{
				echo "<p>There are no activities made.</p><br/>";
			}
			else { ?><!-- It will output the table of records for the date today-->
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example"> 
					<tbody> 
					<?php 
					$cnt=1;
					foreach ($query->result() as $row)
					{ 
					?>
						<tr><?php echo $row->date; ?></tr>
						<tr>
							<td><?php echo $row->date; ?></td>
							<td>
								<?php 
								if ($row->table=="employee")
								{
									if ($row->action=="insert") 
										echo $row->user.' inserted '.$row->person.' on the list of employee.';
									else if ($row->action=="update")
										echo $row->user.' updated the profile of '.$row->person;
									else 
										echo $row->user.' deleted '.$row->person.' on the list of employee.';
								}
								?>
							</td>
						</tr>
					<?php 
					$cnt++; 
					} ?>
					</tbody>  
				</table>
			<?php }?>
</div>
</body>
</html>