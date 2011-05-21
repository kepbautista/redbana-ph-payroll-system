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
	<style>th{text-align: left;}</style>
</head>

<body>
<h3>Compute Payroll</h3>

<form name="FRM"  method="post"  accept-charset="utf-8" action="<?php echo site_url(); ?>/computepayroll/payrollinfoview">
<table>
	<tr>
		<th>Cutoff Period</th>
		<td><?php echo form_dropdown('payperiod', $payperiod);?></td>
	</tr>
</table>
<input type='submit' name='GeneratePayroll' id='GeneratePayroll' value='Generate Payroll'/>
</form>
<div style="color: red">
<?php echo validation_errors(); ?>
</div>
</body>
</html>