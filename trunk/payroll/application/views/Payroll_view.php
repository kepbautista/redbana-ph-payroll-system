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
	<style>th{text-align: center;}</style>
	<link rel="stylesheet" href="<?php echo base_url();?>/jqtransform/demo.css" type="text/css" media="all" />
	<script type="text/javascript" src="<?php echo base_url();?>devtools/jquery-1.5.2"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#GeneratePayroll').click(function(){
			$.post("<?php echo base_url();?>devtools/payrollAdjustments.php", {
             payperiod: $('#payperiod').val(),
          },
          function(data){
                $("#viewpayroll").html(data);
          }
		  );
		});
	});
	</script>
</head>

<body>
<h3>View Payroll</h3>

<table>
	<tr>
		<th>Pay Period</th>
		<td>
		<select id='payperiod' name='payperiod'>
		<?php
			foreach($payperiod as $key => $value)
				echo "<option value='".$key."'>".$value."</option>";
		?>
		</select>
		</td>
	</tr>
</table>
<input type='button' name='GeneratePayroll' id='GeneratePayroll' value='Generate Payroll'/>

<div name='viewpayroll' id='viewpayroll'>
</div>

</body>
</html>