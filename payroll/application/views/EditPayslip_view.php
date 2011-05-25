<!--
/*File Name: EditPayslip_view.php
  Program Description: Compute Payroll for current Payperiod
*/
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>Edit Pay Slip</title>
	<style>
		th{text-align: left;}
		.numeric{text-align: right; width: 60px}
		td{text-align: right;}
	</style>
</head>

<body>
<h3>Initial Pay Slip for <?php echo $start_date." to ".$end_date;?></h3>
<form method="post" accept-charset="utf-8" action="<?php echo site_url(); ?>/payroll/editpayslip">
<div style='color:red'>
	<?php if(!isset($_POST['edit'])) echo validation_errors();?>
</div>
<table>
	<tr>
		<th>Employee Number:</th>
		<td style='text-align:left'>
		<?php echo $EmployeeNumber;?>
		<input type='hidden' id='EmployeeNumber' name='EmployeeNumber' value='<?php echo $EmployeeNumber?>'/>
		</td>
	</tr>
	<tr>
		<th>Employee Name:</th>
		<td style='text-align:left'>
		<?php echo $EmployeeName;?>
		<input type='hidden' id='EmployeeName' name='EmployeeName' value='<?php echo $EmployeeName?>'/>
		</td>
	</tr>
	<tr>
		<th>Daily Rate:</th>
		<td>
		<input type='text' class='numeric' id='DailyRate' name='DailyRate' value='<?php echo $DailyRate;?>'/>
		</td>
	</tr>
	<tr>
		<th>Pay Period Rate:</th>
		<td>
		<?php echo $PayPeriodRate;?>
		<input type='hidden' id='PayPeriodRate' name='PayPeriodRate' value='<?php echo $PayPeriodRate?>'/>
		</td>
	</tr>
	<tr>
		<th>Absences/Tardiness:</th>
		<td>
		<?php echo $AbsencesTardiness;?>
		<input type='hidden' id='AbsencesTardiness' name='AbsencesTardiness' value='<?php echo $AbsencesTardiness?>'/>
		</td>
	</tr>
	<tr>
		<th>Overtime Pay:</th>
		<td>
		<input type='hidden' id='Overtime' name='Overtime' value='<?php echo $Overtime?>'/>
		<?php echo $Overtime;?>
		</td>
	</tr>
	<tr>
		<th>Holiday Pay:</th>
		<td>
		<input type='hidden' id='Holiday' name='Holiday' value='<?php echo $Holiday?>'/>
		<?php echo $Holiday;?>
		</td>
	</tr>
	<tr>
		<th>Salary Adjustment (Tax Refund):</th>
		<td><input type='text' class='numeric' id='TaxRefund' name='TaxRefund' value='<?php echo $TaxRefund;?>'/></td>
	</tr>
	<tr>
		<th>Night Differential:</th>
		<td>
		<input type='hidden' id='NightDifferential' name='NightDifferential' value='<?php echo $NightDifferential?>'/>
		<?php echo $NightDifferential;?>
		</td>
	</tr>
	<tr>
		<th>Gross Pay:</th>
		<td>
		<input type='hidden' id='GrossPay' name='GrossPay' value='<?php echo $GrossPay?>'/>
		<?php echo $GrossPay;?>
		</td>
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
		<td>
		<input type='hidden' id='TotalPay' name='TotalPay' value='<?php echo $TotalPay?>'/>
		<?php echo $TotalPay;?>
		</td>
	</tr>
	<tr>
		<th>Withholding Tax Basis:</th>
		<td>
		<input type='hidden' id='WithholdingBasis' name='WithholdingBasis' value='<?php echo $WithholdingBasis?>'/>
		<?php echo $WithholdingBasis;?>
		</td>
	</tr>
	<tr>
		<th>Withholding Tax:</th>
		<td>
		<input type='hidden' id='WithholdingTax' name='WithholdingTax' value='<?php echo $WithholdingTax?>'/>
		<?php echo $WithholdingTax;?>
		</td>
	</tr>
	<tr>
		<th>SSS:</th>
		<td>
		<input type='hidden' id='SSS' name='SSS' value='<?php echo $SSS?>'/>
		<?php echo $SSS;?>
		</td>
	</tr>
	<tr>
		<th>Philhealth:</th>
		<td>
		<input type='hidden' id='Philhealth' name='Philhealth' value='<?php echo $Philhealth?>'/>
		<?php echo $Philhealth;?>
		</td>
	</tr>
	<tr>
		<th>Pag-Ibig:</th>
		<td>
		<input type='hidden' id='Pagibig' name='Pagibig' value='<?php echo $Pagibig?>'/>
		<?php echo $Pagibig;?>
		</td>
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
		<td>
		<input type='hidden' id='NetPay' name='NetPay' value='<?php echo $NetPay?>'/>
		<?php echo $NetPay;?>
		</td>
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

<input type='hidden' id='start_date' name='start_date' value='<?php echo $start_date?>'/>
<input type='hidden' id='end_date' name='end_date' value='<?php echo $end_date?>'/>
<input type='submit' id='editpayslip' name='editpayslip' value='Edit Payslip'/>
<input type='reset' id='reset' name='reset' value='Reset'/>
</form>

</body>
</html>