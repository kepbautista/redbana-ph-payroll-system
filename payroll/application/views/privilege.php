<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>View Record </title>
		<!-- For JQTRANSFORM-->
		<link rel="stylesheet" href="<?php echo base_url();?>css/profile.css" type="text/css" media="all" />
</head>
<body id="dt_example">
	<?php
	if ($rows==0)
	{
		echo "<h1>Sorry,No user right exist.</h1>";
	}
	else
	{
	?>
	<h1>Privileges </h1>
	<?php
		foreach ($query as $row)
		{
			echo $row->privilege;
		}
		echo form_open('employee/insertPriv'); 
		echo form_checkbox('privilege[]',"Add Employee");
		echo form_checkbox('privilege[]',"View Employee");
		echo form_checkbox('privilege[]',"Edit Table");
		echo form_submit('mysubmit','Add'); 
		echo form_close(); 
	}
	?>
</body>
</html>