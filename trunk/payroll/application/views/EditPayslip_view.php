<!--
/*File Name: ComputePayroll_view.php
  Program Description: Compute Payroll for current Payperiod
*/
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>Compute Payroll</title>
	<style>
		th{text-align: left;}
		.numeric{text-align: right; width: 60px}
		td{text-align: right;}
	</style>
</head>

<body>
<h3>Initial Pay Slip for <?php echo $start_date." to ".$end_date;?></h3>
<form>
<table>
	<tr>
		<th>Employee Number:</th>
		<td style='text-align:left'><?php echo $EmployeeNumber;?></td>
	</tr>
	<tr>
		<th>Employee Name:</th>
		<td style='text-align:left'><?php echo $EmployeeName;?></td>
	</tr>
	<tr>
		<th>Daily Rate:</th>
		<td><input type='text' class='numeric' id='DailyRate' name='DailyRate' value='<?php echo $DailyRate;?>'/></td>
	</tr>
	<tr>
		<th>Pay Period Rate:</th>
		<td><?php echo $PayPeriodRate;?></td>
	</tr>
	<tr>
		<th>Absences/Tardiness:</th>
		<td><span><?php echo $AbsencesTardiness;?></span></td>
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
		<th>Salary Adjustment (Tax Refund):</th>
		<td><input type='text' class='numeric' id='TaxRefund' name='TaxRefund' value='<?php echo $TaxRefund;?>'/></td>
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
		<td><input type='text' class='numeric' id='NonTax' name='NonTax' value='<?php echo $NonTax;?>'></td>
	</tr>
	<tr>
		<th>Tax Shield:</th>
		<td><input type='text' class='numeric' id='TaxShield' name='TaxShield' value='<?php echo $TaxShield;?>'></td>
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
		<td><input type='text' class='numeric' id='PagibigLoan' name='PagibigLoan' value='<?php echo $PagibigLoan;?>'></td>
	</tr>
	<tr>
		<th>SSS Loan:</th>
		<td><input type='text' class='numeric' id='SSSLoan' name='SSSLoan' value='<?php echo $SSSLoan;?>'></td>
	</tr>
	<tr>
		<th>Company Loan:</th>
		<td><input type='text' class='numeric' id='CompanyLoan' name='CompanyLoan' value='<?php echo $CompanyLoan;?>'></td>
	</tr>
	<tr>
		<th>Advances to Officer:</th>
		<td><input type='text' class='numeric' id='AdvancestoOfficer' name='AdvancestoOfficer' value='<?php echo $AdvancestoOfficer;?>'></td>
	</tr>
	<tr>
		<th>Cellphone Charges:</th>
		<td><input type='text' class='numeric' id='CellphoneCharges' name='CellphoneCharges' value='<?php echo $CellphoneCharges;?>'></td>
	</tr>
	<tr>
		<th>Advances to Employee:</th>
		<td><input type='text' class='numeric' id='AdvancestoEmployee' name='AdvancestoEmployee' value='<?php echo $AdvancestoEmployee;?>'></td>
	</tr>
	<tr>
		<th>Net Pay:</th>
		<td><?php echo $NetPay;?></td>
	</tr>
	<tr>
		<th>Remarks:</th>
		<td><input type='text' id='Remarks' name='Remarks' value='<?php echo $Remarks;?>'></td>
	</tr>
	<tr>
		<th>Status:</th>
		<td><input type='text' id='Status' name='Status' value='<?php echo $Status;?>'></td>
	</tr>
</table>

<input type='hidden' id='EmployeeNumber' name='EmployeeNumber' value='<?php echo $EmployeeNumber?>'/>
<input type='hidden' id='start_date' name='start_date' value='<?php echo $start_date?>'/>
<input type='hidden' id='end_date' name='end_date' value='<?php echo $end_date?>'/>
</form>

</body>
</html>