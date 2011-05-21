<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>View Record </title>
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
	<?php
	if ($rows==0)
	{
		echo "<h1>Sorry,No such user right exist.</h1>";
	}
	else
	{
	?>
	<?php	
		foreach ($query as $row)
		{
			echo $row->privilege.' and ';
		}
		function set($priv,$query1)
		{
		$result=0;
			foreach ($query1 as $row)
			{
				if ($priv==$row->privilege) $result=1;
			}
		return $result;
		}
		echo form_open('employee/insertPriv'); 
		echo form_hidden('user',$user); 
		?>
		<table>
			<tr><th colspan=2>Manipulate Employee Details</th></tr>
			<tr>
				<td ><?php
						if (set("allleave",$query)==1){
							echo form_checkbox('allleave','allleave','TRUE'); echo form_label('View all File leave', 'allleave');}
						else{
							echo form_checkbox('allleave','allleave'); echo form_label('View all File leave', 'allleave');}?>
				</td>
				<td ><?php 
						if (set("addemp",$query)==1){
							echo form_checkbox('addemp','addemp','true'); echo form_label('Insert an Employee', 'addemp');}
						else{
							echo form_checkbox('addemp','addemp'); echo form_label('Insert an Employee', 'addemp');}?>
				</td>
			</tr>
			<tr>
				<td><?php 
						if (set("viewemp",$query)==1){
							echo form_checkbox('viewemp','viewemp','true'); echo form_label('View all Employee details', 'viewemp');}
						else{
								echo form_checkbox('viewemp','viewemp'); echo form_label('View all Employee details', 'viewemp');}?>
				</td>
				<td><?php 
						if (set("editemp",$query)==1){
							echo form_checkbox('editemp','editemp','true');echo form_label('Edit Employee Details', 'editemp');}
						else{
							echo form_checkbox('editemp','editemp');echo form_label('Edit Employee Details', 'editemp');}?>
				</td>
			</tr>
			<tr >
				<td ><?php 
						if (set("accleave",$query)==1){
							echo form_checkbox('accleave','accleave','true'); echo form_label('Accept File Leave', 'accleave');}
						else{
							echo form_checkbox('accleave','accleave'); echo form_label('Accept File Leave', 'accleave');}?>
				</td>
			</tr>
			<tr><th colspan=2>Manipulate Maintenance Table</th></tr>
			<tr>
				<td><?php 
						if (set("position",$query)==1){
							echo form_checkbox('position','position','true');echo form_label('Position Maintenance Table', 'position');}
						else{
							echo form_checkbox('position','position');echo form_label('Position Maintenance Table', 'position');}?>
				</td>
				<td><?php 
						if (set("dept",$query)==1){
							echo form_checkbox('dept','dept','true');echo form_label('Department Maintenance', 'dept');}
						else{ 
							echo form_checkbox('dept','dept');echo form_label('Department Maintenance', 'dept');}?>
				</td>
			</tr>
			<tr>
				<td><?php 
						if (set("taxstatus",$query)==1){
							echo form_checkbox('taxstatus','taxstatus','true');echo form_label('Tax Status Maintenance', 'taxstatus');}
						else{ 
							echo form_checkbox('taxstatus','taxstatus');echo form_label('Tax Status Maintenance', 'taxstatus');}?>
				</td>
				<td><?php 
						if (set("shift",$query)==1){
							echo form_checkbox('shift','shift','true');echo form_label('Shift Hours Maintenance', 'shift');}
						else{
							echo form_checkbox('shift','shift');echo form_label('Shift Hours Maintenance', 'shift');}?>
				</td>
			</tr>
			<tr>
				<td><?php 
						if (set("sss",$query)==1){
							echo form_checkbox('sss','sss','true');echo form_label('SSS Table', 'sss');}
						else{
							echo form_checkbox('sss','sss');echo form_label('SSS Table', 'sss');}?></td>
				<td><?php 
						if (set("phil",$query)==1){
							echo form_checkbox('phil','phil','true');echo form_label('Philhealth Table', 'phil');}
						else{
							echo form_checkbox('phil','phil');echo form_label('Philhealth Table', 'phil');}?>
				</td>
			</tr>
			<tr>
				<td><?php
						if (set("wth",$query)==1){
							echo form_checkbox('wth','wth','true');echo form_label('Withholding Tax Table', 'wth');}
						else{
							echo form_checkbox('wth','wth');echo form_label('Withholding Tax Table', 'wth');}?>
				</td>
			</tr>
			<tr><th colspan=2>Default </th></tr>
			<tr>
				<td><?php 
						if (set("viewpay",$query)==1){
							echo form_checkbox('viewpay','viewpay','true');echo form_label('View Payslip', 'viewpay');}
						else{
							echo form_checkbox('viewpay','viewpay');echo form_label('View Payslip', 'viewpay');}?>
				</td>
				<td><?php 
						if (set("viewpay",$query)==1){
							echo form_checkbox('leave','leave','true');echo form_label('File a Leave', 'leave');}
						else{
							echo form_checkbox('leave','leave');echo form_label('File a Leave', 'leave');}?>
				</td>
			</tr>
		</table>
	<?php 
		echo form_submit('mysubmit','Submit'); 
		echo form_close();}
	?>
</body>
</html>