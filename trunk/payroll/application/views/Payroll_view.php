<!--
/*File Name: Payroll_view.php
  Program Description: Compute Payroll for current Payperiod
*/
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>View Payroll</title>
	<style>th{text-align: center;}</style>
	<link rel="stylesheet" href="<?php echo base_url();?>/jqtransform/demo.css" type="text/css" media="all" />
	<script type="text/javascript" src="<?php echo base_url();?>devtools/jquery-1.5.2"></script>
</head>

<body>
<h3>View Payroll</h3>

<form method='post' accept-charset='utf-8' action='payrollinfoview'>
<table>
	<tr>
		<th>Pay Period</th>
		<td>
		<?php
			echo form_dropdown('payperiod',$payperiod);
		?>
		</td>
	</tr>
</table>
<input type='submit' name='GeneratePayroll' id='GeneratePayroll' value='Generate Payroll'/>
</form>

<div name='viewpayroll' id='viewpayroll'>
<?php
	if(isset($_POST['GeneratePayroll'])){
		echo "<table><tr><th>Employee Number</th>
		 <th style='align:left'>Employee Name</th>
		 <th>Pay Slip</th>";
		 
		if($finalized==false)
			echo "<th>Modify</th>";
		else
			echo "<h4 style='color:red'>This Pay Period 
				is already finalized.</h4>";
			
		echo "</tr>";
		
			foreach($info as $value){
				echo "<tr id='info' name='info'>
					<form method='post' accept-charset='utf-8' 
					action='editpayslip'>
					<td>".$value['EmployeeNumber']."</td>
					<td>".$value['EmployeeName']."</td>
					<td style='text-align:center'>
					<input type='hidden' id='EmployeeNumber' 
					name='EmployeeNumber' value='".$value['EmployeeNumber']."'/>
					<input type='hidden' id='start_date' 
					name='start_date' value='".$start_date."'/>
					<input type='hidden' id='end_date' 
					name='end_date' value='".$end_date."'/>
					<input type='submit' id='netpay' name='netpay' value='View'/></td>";
				if($finalized==false)
					echo "<td><input type='submit' id='edit' name='edit' value='Edit'/></td>";
					
				echo "</form></tr>";
			}
		
		echo "</table>";
	}
?>
</div>

</body>
</html>