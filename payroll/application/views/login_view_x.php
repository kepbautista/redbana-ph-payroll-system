<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Login - REDBANA PAYROLL SYSTEM</title>
<link href="<?php echo base_url(); ?>assets/css/mainstyling.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#announcements
{
	width: 70%;
	float: left;
	overflow: auto;
}
#login_container
{
	width: 30%; overflow:auto;
}
</style>
</head>

<body>
<div id="header" class="center">
	<img src="<?php echo base_url(); ?>assets/images/payroll.png"  alt="header" />
</div>
<div id="header2" class="center">
	<ul class="nav">
		<li class="nav"><a id="nav" href="<?php echo base_url(); ?>">Home</a></li>
	</ul></div>
<div id="container" class="center">
<div id="announcements">
   &nbsp;
</div >
<div id="drdw">
<div id="login_container">
				
				<?php echo form_open('login/view_form'); ?>
				<br/>
				<br/>
				<table>
					<tr>
						<td >Employee Number:</td>
						<td ><input type="text" name="empnum" /></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input type="password" name="password" /></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" value="Log-in" onclick="validate(this)" /></td>
					</tr>
				</table>
						      	
		      	<?php 
		    		if(($this->session->set_flashdata('login_error'))){
		    			//echo 'You entered an incorrect username or password.';
		    		}    		
		    	echo validation_errors()?>
				<br/>		    	
		      	<?php echo form_close();?>      	

</div>
</div>
</div>
<div id="copyright" >
<p>Copyright 2011 | Bautista and Associates Information Systems</p>
</div>
</body>

</html>
