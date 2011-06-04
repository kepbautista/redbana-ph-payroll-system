<!--
/*File Name: ComputePayroll_view.php
  Program Description: Compute Payroll for current Payperiod
*/
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>Pay Slip Viewer</title>
	<style>
		th{text-align: left;}
		.numeric{text-align: right; width: 60px}
		td{text-align: right;}
	</style>
</head>

<?php include 'links.php';?>

<body>
<div>
<br/>
<?php
if(isset($current)){
	echo '<form method="post" accept-charset="utf-8" action="'.site_url().'/payroll/individualpayslip">';
	echo 'Select Pay Period: ';

	echo "<select name='payperiod' id='payperiod'>";
	foreach($payperiod as $key => $value){
		if($key==$current)
			echo "<option value='".$key."' selected='selected'>".$value."</option>";
		else
			echo "<option value='".$key."'>".$value."</option>";
	}
	echo "</select>";
	echo "&nbsp<input type='submit' name='payslip' id='payslip' value='See Pay Slip'/>";
}
?>
</form>
</div>
<h3>Pay Slip for <?php echo $start_date." to ".$end_date;?></h3>
<table>
	<tr>
		<th>Employee Number:</th>
		<td style='text-align:left'>
		<?php echo $EmployeeNumber;?>
		</td>
	</tr>
	<tr>
		<th>Employee Name:</th>
		<td style='text-align:left'>
		<?php echo $EmployeeName;?>
		</td>
	</tr>
	<tr>
		<th>Daily Rate:</th>
		<td><?php echo $DailyRate;?></td>
	</tr>
	<tr>
		<th>Pay Period Rate:</th>
		<td><?php echo $PayPeriodRate;?></td>
	</tr>
	<tr>
		<th>Absences/Tardiness:</th>
		<td><?php echo $AbsencesTardiness;?></td>
	</tr>
	<tr>
		<th>Overtime Pay:</th>
		<td><?php echo $Overtime;?></td>
	</tr>
	<tr>
		<th>Holiday Pay:</th>
		<td><?php echo $Holiday;?></td>
	</tr>
	<tr>
		<th>Holiday Adjustment:</th>
		<td><?php echo $HolidayAdjustment;?></td>
	</tr>
	<tr>
		<th>Salary Adjustment (Tax Refund):</th>
		<td><?php echo $TaxRefund;?></td>
	</tr>
	<tr>
		<th>Night Differential:</th>
		<td><?php echo $NightDifferential;?></td>
	</tr>
	<tr>
		<th>Gross Pay:</th>
		<td><?php echo $GrossPay;?></td>
	</tr>
	<tr>
		<th>Non-Tax:</th>
		<td><?php echo $NonTax;?></td>
	</tr>
	<tr>
		<th>Tax Shield:</th>
		<td><?php echo $TaxShield;?></td>
	</tr>
	<tr>
		<th>Total Pay:</th>
		<td><?php echo $TotalPay;?></td>
	</tr>
	<tr>
		<th>Withholding Tax Basis:</th>
		<td><?php echo $WithholdingBasis;?></td>
	</tr>
	<tr>
		<th>Withholding Tax:</th>
		<td><?php echo $WithholdingTax;?></td>
	</tr>
	<tr>
		<th>SSS:</th>
		<td><?php echo $SSS;?></td>
	</tr>
	<tr>
		<th>Philhealth:</th>
		<td><?php echo $Philhealth;?></td>
	</tr>
	<tr>
		<th>Pag-Ibig:</th>
		<td><?php echo $Pagibig;?></td>
	</tr>
	<tr>
		<th>Pag-Ibig Loan:</th>
		<td><?php echo $PagibigLoan;?></td>
	</tr>
	<tr>
		<th>SSS Loan:</th>
		<td><?php echo $SSSLoan;?></td>
	</tr>
	<tr>
		<th>Company Loan:</th>
		<td><?php echo $CompanyLoan;?></td>
	</tr>
	<tr>
		<th>Cellphone Charges:</th>
		<td><?php echo $CellphoneCharges;?></td>
	</tr>
	<tr>
		<th>Advances to Employee:</th>
		<td><?php echo $AdvancestoEmployee;?></td>
	</tr>
	<tr>
		<th>Net Pay:</th>
		<td><?php echo $NetPay;?></td>
	</tr>
	<tr>
		<th>Status:</th>
		<td><?php echo $Status;?></td>
	</tr>
</table>

</body>
</html>