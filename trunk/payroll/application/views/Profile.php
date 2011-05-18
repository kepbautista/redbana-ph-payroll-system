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
	echo "<h1>Sorry,Employee Number doesn't exist.</h1>";
	}
	else
	{
		foreach($query as $row)
		{
		?>
		<h1>Profile of <?php echo $row->title.' '.$row->fname.' '.$row->mname.' '.$row->sname;?></h1>
		<table align="center" >
			<tr><th colspan="2">Main Information</th></tr>	
			<tr>
				<td><label>Birthday: </label><?php echo date('M d, Y', strtotime($row->bdate));?></td>
				<td ><label>Gender: </label><?php echo $row->gender;?></td>
			</tr>
			<tr>
				<td ><label>Tax Status: </label><?php echo $row->tax_status;?></td>
				<td ><label>Civil Status: </label><?php echo $row->civil_status?></td>
			</tr>
			<tr><th colspan="2">Employment Details</th></tr>	
			<tr>
				<td><label>Status: </label><?php echo $row->emp_status;?></td>
				<td><label>Type: </label><?php echo $row->emp_type;?></td>
			</tr>
			<tr>
				<td><label>Department: </label><?php echo $row->dept;?></td>
				<td><label>Position: </label><?php echo $row->position?></td>
			</tr>
			<tr>
				<td><label>Starting Date: </label><?php echo date('M d, Y', strtotime($row->sdate));?></td>
				<td><label>Payment Mode: </label><?php echo $row->payment_mode?></td>
			</tr>
			<tr><th colspan="2">Access Information</th></tr>	
			<tr>
				<td><label>User Right: </label><?php echo $row->user_right;?></td>
				<td><label>Password: </label><?php echo $row->password;?></td>
			</tr>
			<tr><th colspan="2">Contact Details</th></tr>	
			<tr>
				<td><label>Home Number: </label><?php echo $row->hphone;?></td>
				<td><label>Mobile Number: </label><?php echo $row->mphone;?></td>
			</tr>
			<tr>
				<td><label>Zip Code: </label><?php echo $row->zipcode;?></td>
				<td><label>Email Address: </label><?php echo $row->email;?></td>
			</tr>
			<tr><td colspan="2"><label>Address: </label><?php echo $row->address?></td></tr>	
			<tr><th colspan="2">Card Numbers</th></tr>	
			<tr>
				<td><label>SSS Number: </label><?php echo $row->sssno;?></td>
				<td><label>TIN Number: </label><?php echo $row->tinno;?></td>
			</tr>
			<tr>
				<td><label>PAG-IBIG Number: </label><?php echo $row->pagibig;?></td>
				<td><label>Philhealth Number: </label><?php echo $row->philno;?></td>
			</tr>
			<tr>
				<td><?php
					$hidden=$row->empnum;
					echo form_open('employee/edit'); 
					echo form_hidden('empnum', $hidden);
					echo form_submit('editEmp','Edit'); 
					echo form_close(); 
				?>
				</td>
				<td>
				<?php
					$hidden=$row->empnum;
					echo form_open('employee/delete'); 
					echo form_hidden('empnum', $hidden);
					echo form_submit('delete','Delete'); 
					echo form_close(); 
				?></td>
			</tr>
		</table>
		<?php
		}
	}
	?>
	<h1><a href="<?php echo base_url();?>index.php/employee/getall">Back</a></h1>
</body>
</html>