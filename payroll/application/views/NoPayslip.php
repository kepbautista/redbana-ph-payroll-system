<!--
/*File Name: ComputePayroll_view.php
  Program Description: Compute Payroll for current Payperiod
*/
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>No Pay Slip Available</title>
</head>

<body>
<?php include 'links.php';?>
<form method="post" accept-charset="utf-8" action="<?php echo site_url(); ?>/payroll/individualpayslip">
<table>
<tr>
<td>Select Pay Period: </td>
<td>
	<select name='payperiod' id='payperiod'>
		<?php
			foreach($payperiod as $key => $value){
				if($key==$current)
					echo "<option value='".$key."' selected='selected'>".$value."</option>";
				else
					echo "<option value='".$key."'>".$value."</option>";
			}
		?>
	</select>
</td>
<td>
	<input type='submit' name='payslip' id='payslip' value='See Pay Slip'/>
</td>
</tr>
</table>
</form>
<h3>No Pay Slip for <?php echo $EmployeeName?> 
(<?php echo $EmployeeNumber?>) 
<br/>during Pay Period 
<?php echo $start_date." to ".$end_date;?>
</h3>
</body>
</html>